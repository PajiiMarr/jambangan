<div 
    wire:ignore
    class="chart-container h-[80vh] w-full"
    x-data="{
        chart: null,
        monthLabels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        init() {
            // Wait for next tick to ensure DOM is ready
            this.$nextTick(() => {
                this.initChart();
                
                // Listen for Livewire updates
                Livewire.on('chartUpdated', (data) => {
                    this.updateChart(data);
                });
                
                // Load initial data
                this.updateChart(@this.chartData);
            });
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
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 300,
                        easing: 'linear'
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
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
        x-init="console.log('Canvas initialized')"
        wire:ignore
    ></canvas>
</div>

@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .chart-container {
        position: relative;
        min-height: 400px;
    }
    canvas {
        width: 100% !important;
        height: 100% !important;
    }
</style>
@endassets