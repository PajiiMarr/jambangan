<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $number = 2;

    public $message = 'hello world';
    public function render()
    {
        return view('livewire.counter');
    }
}
