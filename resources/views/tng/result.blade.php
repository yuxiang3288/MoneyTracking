@extends('layouts.app')

@section('title', 'Parsed Transactions')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-semibold mb-4">Parsed Transactions</h1>

        @if(count($transactions))
            <table class="w-full table-auto border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-3 py-2">Date</th>
                        <th class="px-3 py-2">Type</th>
                        <th class="px-3 py-2">Description</th>
                        <th class="px-3 py-2">Amount</th>
                        <th class="px-3 py-2">Direction</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $tx)
                        <tr class="border-t">
                            <td class="px-3 py-1">{{ $tx['date'] }}</td>
                            <td class="px-3 py-1">{{ $tx['type'] }}</td>
                            <td class="px-3 py-1">{{ $tx['description'] }}</td>
                            <td>RM{{ number_format((float) $tx['amount'], 2) }}</td>
                            <td class="px-3 py-1">{{ $tx['direction'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No transactions found.</p>
        @endif
    </div>
@endsection
