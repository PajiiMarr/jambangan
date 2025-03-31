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

function chartComponent() {
    return {
        selectedYear: '2023',
        selectedMonth: '01',
        chartData: {
            '2023': {
                '01': [12, 19, 3, 5, 2, 3]
            },
        },
        init() {
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

            // Render new chart
            const isDarkMode = document.documentElement.classList.contains('dark');
            const barColor = getComputedStyle(document.documentElement)
                .getPropertyValue('--color-accent')
                .trim() || '#4F46E5';
            const darkModeBarColor = getComputedStyle(document.documentElement)
                .getPropertyValue('--color-red-400')
                .trim() || '#F87171';

            const data = this.chartData[this.selectedYear][this.selectedMonth];

            window.myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: '# of Visitors',
                        data: data,
                        backgroundColor: isDarkMode ? darkModeBarColor : barColor,
                        borderWidth: 1
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            window.initializedComponents.chartInstances.set(ctx.id, window.myChart);
        },
        updateChart() {
            this.renderChart();
        }
    };
}

window.chartComponent = chartComponent;
