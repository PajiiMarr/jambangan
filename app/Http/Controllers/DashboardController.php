<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mock Data with Flux UI-like structure
        $mockDashboardData = [
            'page_views' => [
                'count' => rand(1500, 5000),
                'trend' => '+12%', // Mock percentage trend
                'icon' => 'eye', // Flux UI icon
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

        return view('dashboard', compact('mockDashboardData'));
    }
}
