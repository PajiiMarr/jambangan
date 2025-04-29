<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\General;
use App\Models\Events;
use App\Models\Performances;
use App\Models\Media;
use App\Models\Posts;

class LandingPage extends Controller
{
    public function __invoke()
    {
        $performances = Performances::with('media')
            ->orderBy('created_at', 'desc')
            ->get();

        $general_contents = General::latest()->first();

        $events = Events::select(
            'event_id as id',
            'event_name as title',
            'start_date as start',
            'end_date as end',
            'location',
            'status'
        )
        ->orderBy('start_date', 'asc');

        $posts = Posts::with('media');

        return view('landing', [
            'performances' => $performances,
            'posts' => $posts,
            'events' => $events,
            'general_contents' => $general_contents,
        ]);
    }
}
