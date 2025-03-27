<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventAPIController extends Controller
{
    /**
     * Get events for the authenticated user
     */
    public function index(Request $request)
    {
        // Get query parameters for filtering (optional)
        $start = $request->input('start');
        $end = $request->input('end');

        // Query events
        $query = Events::query()->where('user_id', Auth::id());

        // Apply date filtering if provided
        if ($start) {
            $query->where('end_date', '>=', $start);
        }

        if ($end) {
            $query->where('start_date', '<=', $end);
        }

        // Get events
        $events = $query->get();

        return response()->json($events);
    }
}
