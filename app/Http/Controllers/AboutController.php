<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\General;
use App\Models\Officers;

class AboutController extends Controller
{
    public function index()
    {
        track_page_view('about-public');
        $general_contents = General::latest()->first();
        $officers = Officers::with('media')->get();
        $core_values = \App\Models\CoreValues::all();

        return view('about', [
            'general_contents' => $general_contents,
            'officers' => $officers,
            'core_values' => $core_values
        ]);
    }
} 