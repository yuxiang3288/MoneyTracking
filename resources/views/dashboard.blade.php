@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-3xl font-semibold mb-6">Dashboard</h1>

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
        <div class="relative max-w-md mx-auto aspect-square">
            <canvas id="totalChart" class="w-full h-full"></canvas>
        </div>
    </div>

    <script>
        const dailySpending = @json($dailySpending ?? 0);
        const dailyEarning = @json($dailyEarning ?? 0);
        const monthlySpending = @json($monthlySpending ?? 0);
        const monthlyEarning = @json($monthlyEarning ?? 0);
        const monthlyLabels = @json($monthlyLabels ?? 0);
        const yearlySpending = @json($yearlySpending ?? 0);
        const yearlyEarning = @json($yearlyEarning ?? 0);

        // Daily Spending
        new Chart(document.getElementById('dailyChart'), {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [
                    {
                        label: 'Spending ($)',
                        data: dailySpending,
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68)',
                        fill: false,
                        tension: 0.3,
                        // spanGaps: false
                    },
                    {
                        label: 'Earning ($)',
                        data: dailyEarning,
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94)',
                        fill: false,
                        tension: 0.3,
                        // spanGaps: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });

        // Monthly Spending
        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Spending ($)',
                    data: monthlySpending,
                    backgroundColor: 'rgb(239, 68, 68)'
                },
                {
                    label: 'Earning ($)',
                    data: monthlyEarning,
                    backgroundColor: 'rgba(34, 197, 94)',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Total Spending
        new Chart(document.getElementById('totalChart'), {
            type: 'doughnut',
            data: {
                labels: ['Spent', 'Remaining'],
                datasets: [{
                    data: [yearlySpending, yearlyEarning - yearlySpending],
                    backgroundColor: ['rgb(239, 68, 68)', 'rgba(34, 197, 94)']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
@endsection