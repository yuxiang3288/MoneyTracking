document.addEventListener('DOMContentLoaded', function () {
    const {
        dailySpending,
        dailyEarning,
        monthlySpending,
        monthlyEarning,
        monthlyLabels,
        yearlySpending,
        yearlyEarning
    } = window.chartData;

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
                    tension: 0.3
                },
                {
                    label: 'Earning ($)',
                    data: dailyEarning,
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94)',
                    fill: false,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Monthly Chart
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [
                {
                    label: 'Spending ($)',
                    data: monthlySpending,
                    backgroundColor: 'rgb(239, 68, 68)'
                },
                {
                    label: 'Earning ($)',
                    data: monthlyEarning,
                    backgroundColor: 'rgba(34, 197, 94)'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Doughnut
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
});
