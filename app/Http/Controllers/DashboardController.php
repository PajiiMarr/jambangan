<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoreValues;
use App\Models\General;
use App\Models\Media;
use App\Models\Events;
use App\Models\Posts;
use App\Models\Performances;
use App\Models\PageViews;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public $performancesCount;
    public $postsCount;
    public $eventsCount;

    // Add this property
    public $chartData = [];

    protected $listeners = ['refreshChart' => '$refresh'];

    public function mount()
    {
        $this->dispatch('updateChart', data: $this->chartData);
    }
    
    public function index()
    {
        $performancesCount = Performances::count();
        $postsCount = Posts::count();
        $eventsCount = Events::count();

        
        $pageViewsData = PageViews::selectRaw('year, month, SUM(views) as total_views')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();


        
        $chartData = array_fill(0, 12, 0);

        foreach ($pageViewsData as $view) {
            // Ensure month is between 1-12
            $monthIndex = max(0, min(11, $view->month - 1));
            $chartData[$monthIndex] = $view->total_views;
        }

        // Get all unique years and months for the dropdown
        $years = $pageViewsData->pluck('year')->unique();
        $months = $pageViewsData->pluck('month')->unique();

        // Example dashboard data
        $pageViewsTotal = PageViews::sum('views');

        $mockDashboardData = [
            'performances_count' => [
                'count' => $performancesCount,
                'trend' => '+12%', // You can replace this with real trend logic
                'icon' => 'eye',
            ],
            'posts_count' => [
                'count' => $postsCount,
                'trend' => '+5%',  // Replace as needed
                'icon' => 'check',
            ],
            'events_count' => [
                'count' => $eventsCount,
                'trend' => '+8%',  // Replace as needed
                'icon' => 'event-calendar',
            ],
        ];

        // Temporarily add this to your controller to see the raw data
        
        // Debug the actual data being pulled
        // dd([
        //     'raw_data' => $pageViewsData->toArray(),
        //     'chart_data' => $chartData,
        //     'current_month' => date('n') // Should be 5 for May
        // ]);


        // After preparing $chartData, assign it to the public property

        // Right before the return statement
        \Log::debug('Chart Data:', $chartData);

        return view('dashboard', compact('mockDashboardData', 'chartData', 'years', 'months', 'performancesCount', 'postsCount', 'eventsCount'));
    }

    

}
