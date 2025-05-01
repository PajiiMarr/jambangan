<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\General;
use App\Models\Officers;

class AboutController extends Controller
{
    public function index()
    {
        $general_contents = General::latest()->first();
        $officers = Officers::with('media')->get();

        return view('about', [
            'general_contents' => $general_contents,
            'officers' => $officers
        ]);
    }
} 