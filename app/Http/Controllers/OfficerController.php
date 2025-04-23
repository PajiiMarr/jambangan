<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Officers;

class OfficerController extends Controller
{


    //

    

    public function index()
    {
        // Fetch all officers from the database
        $officers = Officers::all();

        // Return the view with the officers data
        return view('officers', compact('officers'));
    }
}
