<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        // Fetch all officers from the database
        // $officers = Officers::all();

        // Return the view with the officers data
        return view('bookings');
    }
}
