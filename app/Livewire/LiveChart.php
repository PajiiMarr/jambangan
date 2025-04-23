<?php
namespace App\Livewire;

use Livewire\Component;

class DynamicChart extends Component
{
    public $hello = "hellooo";
    public $selectedYear = '2023';
    public $selectedMonth = '01';
    public $chartData = [];
    // public $mockDashboardData = [
    //     'page_views' => rand(500, 2000),  // Random page views count
    //     'posts_uploaded' => rand(10, 50), // Random posts count
    //     'events_created' => rand(5, 20),  // Random events count
    // ];
    

    public function mount()
    {
        // Initialize chart data when the component is mounted
        $this->updateChartData();
    }

    public function updateChartData()
    {
        // Simulate dynamic data (replace this with your actual data logic)
        $this->chartData = [
            rand(1, 20), // Random data for Red
            rand(1, 20), // Random data for Blue
            rand(1, 20), // Random data for Yellow
            rand(1, 20), // Random data for Green
            rand(1, 20), // Random data for Purple
            rand(1, 20), // Random data for Orange
        ];
    }

    public function render()
    {
        // Render the Livewire vie
        return view('livewire.live-chart');
    }
}
