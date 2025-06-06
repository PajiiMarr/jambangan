<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\General;
use App\Models\Events;
use App\Models\Performances;
use App\Models\Media;
use App\Models\Posts;
use App\Models\Slides;

class LandingPage extends Controller
{
    public function __invoke()
    {
        // Call the page view tracker
        track_page_view('home-public');

        $performances = Performances::with('media')
            ->orderBy('created_at', 'desc')
            ->get();

        $general_contents = General::latest()->first();

        $events = Events::orderBy('start_date', 'asc')->limit(3)->get();

        $posts = Posts::with('media')
            ->orderBy('created_at', 'desc')
            ->get();

        $cover_medias = Slides::join('media', 'slides.slide_id', '=', 'media.slide_id')
            ->select('slides.title', 'slides.subtitle', 'media.file_data')
            ->get();

        return view('landing', [
            'performances' => $performances,
            'posts' => $posts,
            'events' => $events,
            'general_contents' => $general_contents,
            'cover_medias' => $cover_medias
        ]);
    }
}
