@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-3xl font-semibold mb-6">≡ Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Daily Spending Chart -->
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-bold mb-2">Daily Spending</h2>
            <div class="relative w-full aspect-[3/2]">
                <canvas id="dailyChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Monthly Spending Chart -->
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-bold mb-2">Monthly Spending</h2>
            <div class="relative w-full aspect-[3/2]">
                <canvas id="monthlyChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Total Spending Chart -->
    <div class="bg-white p-4 rounded shadow mt-6">
        <h2 class="text-lg font-bold mb-2">Total Saving</h2>

        <div class="flex flex-col md:flex-row justify-center items-center gap-6">
            <!-- Chart -->
            <div class="relative w-full md:w-7/8 max-w-lg">
                <div class="aspect-square">
                    <canvas id="totalChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Info beside chart -->
            <div class="space-y-2 md:w-2/8 w-full text-sm">
                <p class="flex justify-between text-red-600 font-semibold">
                    <span>Total Spending:</span>
                    <span>${{ number_format($yearlySpending, 2) }}</span>
                </p>
                <p class="flex justify-between text-green-600 font-semibold">
                    <span>Total Earning:</span>
                    <span>${{ number_format($yearlyEarning, 2) }}</span>
                </p>
                <p class="flex justify-between text-blue-600 font-semibold">
                    <span>Remaining:</span>
                    <span>${{ number_format($yearlyEarning - $yearlySpending, 2) }}</span>
                </p>
            </div>
        </div>
    </div>



    <script>
        window.chartData = {
            dailySpending: @json($dailySpending ?? []),
            dailyEarning: @json($dailyEarning ?? []),
            monthlySpending: @json($monthlySpending ?? []),
            monthlyEarning: @json($monthlyEarning ?? []),
            monthlyLabels: @json($monthlyLabels ?? []),
            yearlySpending: @json($yearlySpending ?? 0),
            yearlyEarning: @json($yearlyEarning ?? 0),
        };
    </script>

@endsection