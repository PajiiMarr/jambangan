<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Performances;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PerformancesController extends Controller
{
    use WithPagination;
    public $title;
    public $description;
    public $perPage = 10;
    public $selectedPerformance;


    public function mount() {
        $this->title = '';
        $this->description = '';
    }

    public function showPerformance($performance_id)
    {
        $this->selectedPerformance = Performances::with('media')->find($performance_id);
        return view('performances', compact('performance'));
    }

    public function index()
    {
        return view('performances');
    }    
}
