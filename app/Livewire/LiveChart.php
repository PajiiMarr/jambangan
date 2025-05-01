<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\PageViews;

class DynamicChart extends Component
{
    public $hello = "hellooo";
    public $selectedYear = '2023';
    public $selectedMonth = '01';
    public $chartData = [];
    public $pageViewsData = [];
    public $years = [];
    public $months = [];

    public function mount() {
        $pageViewsData = PageViews::selectRaw('year, month, SUM(views) as total_views')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();

                foreach ($pageViewsData as $view) {
                    $this->chartData[$view->year][$view->month] = $view->total_views;
                }
                $years = $pageViewsData->pluck('year')->unique();
                $months = $pageViewsData->pluck('month')->unique();
    }
    
    public function render()
    {
        // Render the Livewire vie
        return view('livewire.live-chart');
    }
}
