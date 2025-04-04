@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
<h1 class="text-3xl font-semibold mb-6">Transactions</h1>

<div class="flex flex-col lg:flex-row gap-6">
    <!-- Filter Sidebar -->
    <aside class="lg:w-1/4 w-full bg-white rounded shadow p-4">
        <h2 class="text-lg font-bold mb-4">Filters</h2>

        <form method="GET" action="{{ route('transactions.index') }}" class="space-y-4">
            <div>
                <label class="block font-medium mb-1">Start Date</label>
                <input type="date" name="start_date" class="w-full border rounded p-2" value="{{ request('start_date') }}">
            </div>

            <div>
                <label class="block font-medium mb-1">End Date</label>
                <input type="date" name="end_date" class="w-full border rounded p-2" value="{{ request('end_date') }}">
            </div>

            <div>
                <label class="block font-medium mb-1">Type</label>
                <select name="type" class="w-full border rounded p-2">
                    <option value="">All</option>
                    <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Income</option>
                    <option value="outcome" {{ request('type') == 'outcome' ? 'selected' : '' }}>Outcome</option>
                </select>
            </div>

            <div>
                <label class="block font-medium mb-1">Category (Title)</label>
                <select name="title" class="w-full border rounded p-2">
                    <option value="">All</option>
                    <option value="Food" {{ request('title') == 'Food' ? 'selected' : '' }}>Food</option>
                    <option value="Shopping" {{ request('title') == 'Shopping' ? 'selected' : '' }}>Shopping</option>
                    <option value="Salary" {{ request('title') == 'Salary' ? 'selected' : '' }}>Salary</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Apply Filters</button>
        </form>
    </aside>

    <!-- Transactions Table -->
    <div class="lg:w-3/4 w-full bg-white rounded shadow p-4">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2 text-left">Date</th>
                    <th class="border p-2 text-left">Title</th>
                    <th class="border p-2 text-left">Description</th>
                    <th class="border p-2 text-right">Amount</th>
                    <th class="border p-2 text-left">Type</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr>
                        <td class="border p-2">{{ $transaction->date }}</td>
                        <td class="border p-2">{{ $transaction->title }}</td>
                        <td class="border p-2">{{ $transaction->description }}</td>
                        <td class="border p-2 text-right {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type == 'income' ? '+' : '-' }} ${{ number_format($transaction->amount, 2) }}
                        </td>
                        <td class="border p-2">{{ ucfirst($transaction->type) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4">No transactions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    </div>

    <!-- Floating Button -->
    <button x-data="{ show: false }" @click="show = true"
        class="fixed bottom-6 right-6 bg-blue-600 text-white px-4 py-2 rounded-full shadow-lg hover:bg-blue-700 z-50">
        + Add Transaction
    </button>

    <!-- Modal -->
    <div x-data="{ showModal: false }" class="relative">
        <!-- Floating Add Button -->
        <button @click="showModal = true"
            class="fixed bottom-6 right-6 bg-blue-600 text-white px-4 py-2 rounded-full shadow-lg hover:bg-blue-700 z-50">
            + Add Transaction
        </button>

        <!-- Modal -->
        <div x-show="showModal" x-cloak class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
                <!-- Close Button -->
                <button @click="showModal = false" class="absolute top-2 right-2 text-gray-500 text-xl hover:text-red-600">
                    &times;
                </button>

                <h2 class="text-xl font-bold mb-4">Add Transaction</h2>

                <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block mb-1 font-medium">Date</label>
                        <input type="date" name="date" class="w-full border rounded p-2" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Title (Category)</label>
                        <input type="text" name="title" class="w-full border rounded p-2" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Description</label>
                        <input type="text" name="description" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Amount</label>
                        <input type="number" name="amount" step="0.01" class="w-full border rounded p-2" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Type</label>
                        <select name="type" class="w-full border rounded p-2" required>
                            <option value="income">Income</option>
                            <option value="outcome">Outcome</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection