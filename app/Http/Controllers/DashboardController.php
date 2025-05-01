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


class DashboardController extends Controller
{
    public function index()
    {
        // Fetch unique years and months from the PageViews model
        // Fetch and calculate page views by year and month
        $pageViewsData = PageViews::selectRaw('year, month, SUM(views) as total_views')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Prepare chart data
        $chartData = [];
        foreach ($pageViewsData as $view) {
            $chartData[$view->year][$view->month] = $view->total_views;
        }

        // Get all unique years and months for the dropdown
        $years = $pageViewsData->pluck('year')->unique();
        $months = $pageViewsData->pluck('month')->unique();

        // Example dashboard data
        $mockDashboardData = [
            'page_views' => [
                'count' => rand(1500, 5000),
                'trend' => '+12%',
                'icon' => 'eye',
            ],
            'posts_uploaded' => [
                'count' => rand(50, 200),
                'trend' => '-3%',
                'icon' => 'check',
            ],
            'events_created' => [
                'count' => rand(10, 50),
                'trend' => '+8%',
                'icon' => 'event-calendar',
            ],
        ];

        // dd($pageViewsData); // Check if you're getting data from the query
        // dd($chartData); // Check the structure of your chart data

        return view('dashboard', compact('mockDashboardData', 'chartData', 'years', 'months'));
    }

    

}
