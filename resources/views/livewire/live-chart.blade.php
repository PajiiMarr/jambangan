<div 
    wire:ignore
    class="chart-container w-full"
    x-data="{
        chart: null,
        monthLabels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        init() {
            // Initialize chart when component is mounted
            this.initChart();
            
            // Listen for Livewire updates
            Livewire.on('chartUpdated', (data) => {
                this.updateChart(data);
            });
            
            // Load initial data
            this.updateChart(@this.chartData);
        },
        initChart() {
            const ctx = this.$el.querySelector('#liveViewsChart');
            if (this.chart) {
                this.chart.destroy();
            }
            
            this.chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: this.monthLabels,
                    datasets: [{
                        label: 'Page Views',
                        data: Array(12).fill(0),
                        backgroundColor: getComputedStyle(document.documentElement).getPropertyValue('--color-accent').trim() || 'rgba(239, 68, 68, 0.7)', // fallback to Tailwind red-500
                        borderColor: getComputedStyle(document.documentElement).getPropertyValue('--color-accent-content').trim() || 'rgba(220, 38, 38, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    animation: {
                        duration: 300,
                        easing: 'linear'
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: (context) => `Views: ${context.raw}`
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        },
        updateChart(data) {
            if (!this.chart) this.initChart();
            
            // Convert data to regular array if it's a Proxy
            const chartData = Array.isArray(data) ? [...data] : Array(12).fill(0);
            
            this.chart.data.datasets[0].data = chartData;
            this.chart.update();
            
            console.log('Chart data updated:', chartData);
        }
    }"
>
    <canvas 
        id="liveViewsChart"
        wire:ignore
    ></canvas>
</div>

@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .chart-container {
        position: relative;
        height: 400px;
        width: 100%;
    }
    canvas {
        width: 100% !important;
        height: 100% !important;
    }
</style>
@endassets