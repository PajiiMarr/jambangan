<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogsController extends Model
{
    public function index()
    {
        return view('admin-logs');
    }
}
