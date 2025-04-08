<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $today = date('Y-m-d');
        $currentYear = Carbon::now()->year;
        $dayOfWeek = date('w', strtotime($today)); // 0 = Sunday

        $startOfWeek = date('Y-m-d', strtotime("-" . ($dayOfWeek - 1) . " days", strtotime($today)));

        $weekDates = collect(range(0, 6))->map(function ($i) use ($startOfWeek) {
            return date('Y-m-d', strtotime("+{$i} days", strtotime($startOfWeek)));
        });

        $spendingData = Transaction::where('user_id', $userId)
            ->where('type', 'outcome')
            ->whereBetween('date', [$weekDates->first(), $weekDates->last()])
            ->select(DB::raw('DATE(date) as day'), DB::raw('SUM(amount) as total'))
            ->groupBy('day')
            ->pluck('total', 'day');

        $earningData = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('date', [$weekDates->first(), $weekDates->last()])
            ->select(DB::raw('DATE(date) as day'), DB::raw('SUM(amount) as total'))
            ->groupBy('day')
            ->pluck('total', 'day');

        $spendingRawMonthly = Transaction::where('user_id', $userId)
            ->where('type', 'outcome')
            ->whereYear('date', $currentYear)
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month'); 
        $earningRawMonthly = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('date', $currentYear)
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month'); 

        $dailySpending = $weekDates->map(fn(string $date): mixed => $spendingData[$date] ?? 0);
        $dailyEarning = $weekDates->map(fn(string $date): mixed => $earningData[$date] ?? 0);

        // $dailyLabels = $weekDates->map(fn($date) => date('D', strtotime($date)));

        // Monthly and total can stay static or fetched similarly
        $monthlySpending = collect(range(1, 12))->map(function ($m) use ($spendingRawMonthly) {
            return $spendingRawMonthly[$m] ?? 0;
        });

        $monthlyEarning = collect(range(1, 12))->map(function ($m) use ($earningRawMonthly) {
            return $earningRawMonthly[$m] ?? 0;
        });
        $monthlyLabels = collect(range(1, 12))->map(fn($m) => date('M', mktime(0, 0, 0, $m, 1)));


        $yearlySpending = $monthlySpending->sum(); // total outcome this year
        $yearlyEarning = $monthlyEarning->sum(); // total income this year

        if($yearlyEarning < $yearlySpending ){
            $yearlyEarning = $yearlySpending;
        }

        return view('dashboard', compact('dailySpending', 'dailyEarning', 'monthlySpending', 'monthlyEarning', 'monthlyLabels', 'yearlySpending', 'yearlyEarning'));
    }
}
