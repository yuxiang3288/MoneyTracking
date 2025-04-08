<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id());

        $titles = [
            'Food',
            'Shopping',
            'Salary',
            'Transport',
            'Bills',
            'Entertainment',
            'Groceries',
            'Others'
        ];

        if ($request->start_date && $request->end_date) {
            $start = Carbon::parse($request->start_date);
            $end = Carbon::parse($request->end_date);
        } else {
            $month = $request->input('month', Carbon::now()->format('Y-m'));
            $start = Carbon::parse($month)->startOfMonth();
            $end = Carbon::parse($month)->endOfMonth();
        }

        $query->whereBetween('date', [$start, $end]);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('title')) {
            $query->where('title', $request->title);
        }

        $transactions = $query->orderBy('date', 'desc')->paginate(15);

        $currentDate = Carbon::parse($start);
        $prevMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();

        $currency = Auth::user()->preferred_currency ?? 'USD';
        $symbol = currencySymbol($currency);
        
        return view('transactions.index', [
            'transactions' => $transactions,
            'currentDate' => $currentDate,
            'prevMonth' => $prevMonth,
            'nextMonth' => $nextMonth,
            'titles' => $titles,
            'symbol' => $symbol
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,outcome',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'type' => $request->type,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully.');
    }
}
