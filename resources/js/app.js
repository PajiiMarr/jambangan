import Chart from 'chart.js/auto';

window.initializedComponents = {
    chartInstances: new Map()
};

document.addEventListener('livewire:navigated', () => {
    FilePond.parse(document.body);
});

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('myChart')) {
        const chartElements = document.querySelectorAll('[x-data*="chartComponent"]');
        if (chartElements.length > 0) {
            chartElements.forEach(el => {
                if (window.Alpine) {
                    window.Alpine.initTree(el);
                }
            });
        }
    }
});

function chartComponent(chartData) {
    // Convert Proxy to plain object to safely access the data
    const plainData = JSON.parse(JSON.stringify(chartData));
    console.log('Chart Data (plain):', plainData);

    return {
        selectedYear: '2025',
        selectedMonth: '05',
        chartData: plainData,
        init() {
            console.log('Initial Chart Data:', this.chartData);
            this.$nextTick(() => {
                this.renderChart();
            });
        },
        renderChart() {
            const ctx = document.getElementById('myChart');
            if (!ctx) return;
        
            if (window.myChart instanceof Chart) {
                window.myChart.destroy();
            }
        
            const isDarkMode = document.documentElement.classList.contains('dark');
            const barColor = getComputedStyle(document.documentElement)
                .getPropertyValue('--color-accent')
                .trim() || '#4F46E5';
            const darkModeBarColor = getComputedStyle(document.documentElement)
                .getPropertyValue('--color-red-400')
                .trim() || '#F87171';
        
            // Get the total views for the selected month
            const monthTotal = this.chartData[this.selectedYear]?.[this.selectedMonth] || 0;
            
            // Since you only have monthly totals (not daily), we'll distribute it evenly for visualization
            const daysInMonth = 31;
            const averageDailyViews = Math.round(monthTotal / daysInMonth);
            
            const labels = Array.from({length: daysInMonth}, (_, i) => `Day ${i + 1}`);
            const dataPoints = Array(daysInMonth).fill(averageDailyViews);

            console.log('Processed Chart Data:', {
                monthTotal,
                averageDailyViews,
                labels,
                dataPoints
            });
        
            window.myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '# of Visitors',
                        data: dataPoints,
                        backgroundColor: isDarkMode ? darkModeBarColor : barColor,
                        borderWidth: 1
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Visitors'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Days of the Month'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: `Monthly Visitors for ${this.selectedMonth}/${this.selectedYear} (Total: ${monthTotal})`
                        }
                    }
                }
            });
        },
        updateChart() {
            console.log('Updating chart with:', {
                year: this.selectedYear,
                month: this.selectedMonth
            });
            this.renderChart();
        }
    };
}
window.chartComponent = chartComponent;
