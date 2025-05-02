<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PageViews;

class LiveChart extends Component
{
    public array $chartData = [];
    public bool $readyToLoad = false;

    protected $listeners = ['refreshChart' => 'loadChartData'];

    public function mount()
    {
        $this->readyToLoad = true;
        $this->loadChartData();
    }

    public function loadChartData()
    {
        $pageViewsData = PageViews::selectRaw('year, month, SUM(views) as total_views')
            ->where('year', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('month', 'asc')
            ->get();
    
        $this->chartData = array_fill(0, 12, 0);
    
        foreach ($pageViewsData as $view) {
            $monthIndex = $view->month - 1;
            if ($monthIndex >= 0 && $monthIndex < 12) {
                $this->chartData[$monthIndex] = (int)$view->total_views;
            }
        }
    
        $this->dispatch('chartUpdated', data: $this->chartData);
    }

    public function render()
    {
        return view('livewire.live-chart');
    }
}