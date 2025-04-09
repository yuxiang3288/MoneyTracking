document.addEventListener('DOMContentLoaded', function () {
    const {
        dailySpending,
        dailyEarning,
        monthlySpending,
        monthlyEarning,
        monthlyLabels,
        yearlySpending,
        yearlyEarning,
        currencySymbol
    } = window.chartData;

    new Chart(document.getElementById('dailyChart'), {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [
                {
                    label: `Spending (${currencySymbol})`,
                    data: dailySpending,
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68)',
                    fill: false,
                    tension: 0.3
                },
                {
                    label: `Earning (${currencySymbol})`,
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
                    label: `Spending (${currencySymbol})`,
                    data: monthlySpending,
                    backgroundColor: 'rgb(239, 68, 68)'
                },
                {
                    label: `Earning (${currencySymbol})`,
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
    const spent = yearlySpending;
    const earned = yearlyEarning;

    let chartData = [];
    let chartLabels = ['Spent', 'Remaining'];
    let chartColors = [];

    if (earned <= 0 || spent >= earned) {
        chartData = [1];
        chartLabels = ['Spent'];
        chartColors = ['rgb(239, 68, 68)'];
    } else {
        chartData = [spent, earned - spent];
        chartColors = ['rgb(239, 68, 68)', 'rgba(34, 197, 94)'];
    }

    new Chart(document.getElementById('totalChart'), {
        type: 'doughnut',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: chartColors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
