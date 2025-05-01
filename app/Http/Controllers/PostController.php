<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\General;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        track_page_view('posts-public');
        $posts = Posts::with(['media', 'user', 'events', 'performances'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $general_contents = General::latest()->first();

        return view('post-user', compact('posts', 'general_contents'));
    }

    public function show($id)
    {
        $post = Posts::with(['media', 'user', 'events', 'performances'])
            ->findOrFail($id);
            
        $general_contents = General::latest()->first();

        return view('post-details', compact('post', 'general_contents'));
    }
} 