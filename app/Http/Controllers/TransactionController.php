<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id());

        // Filter by date range
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        // Filter by transaction type (income/outcome)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by category (title)
        if ($request->filled('title')) {
            $query->where('title', $request->title);
        }

        $transactions = $query->orderBy('date', 'desc')->paginate(15); // 10 per page

        return view('transactions.index', compact('transactions'));
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
