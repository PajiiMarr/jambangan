<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\General;
use App\Models\Booking;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    public function index()
    {
        // Admin view for managing bookings
        $bookings = Booking::orderBy('created_at', 'desc')->get();
        return view('bookings', compact('bookings'));
    }

    public function publicIndex()
    {
        $general_contents = General::latest()->first();
        
        return view('bookings-public', [
            'general_contents' => $general_contents
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'event_date' => 'required|date|after:today',
            'event_type' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        Booking::create($validated);

        Session::flash('success', 'Your booking request has been submitted successfully! We will contact you soon.');

        return redirect()->route('bookings-public');
    }
}
