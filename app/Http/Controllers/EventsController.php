<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\General;

class EventsController extends Controller
{
    public function index()
    {
        $events = Events::with(['media', 'posts.media'])->get();
        $general_contents = General::latest()->first();

        return view('events', [
            'events' => $events,
            'general_contents' => $general_contents
        ]);
    }

    public function show($id)
    {
        $event = Events::with(['media', 'posts.media'])->findOrFail($id);
        $general_contents = General::latest()->first();

        return view('event-details', [
            'event' => $event,
            'general_contents' => $general_contents
        ]);
    }
} 