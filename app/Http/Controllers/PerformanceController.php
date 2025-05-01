<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Performances;
use App\Models\General;
use App\Models\Posts;

class PerformanceController extends Controller
{
    public function index()
    {
        track_page_view('performances-public');
        $performances = Performances::with(['media', 'posts.media'])->get();
        $general_contents = General::latest()->first();

        return view('performances', [
            'performances' => $performances,
            'general_contents' => $general_contents
        ]);
    }

    public function show($id)
    {
        $performance = Performances::with(['media', 'posts.media'])->findOrFail($id);
        $general_contents = General::latest()->first();

        return view('performance-details', [
            'performance' => $performance,
            'general_contents' => $general_contents
        ]);
    }
} 