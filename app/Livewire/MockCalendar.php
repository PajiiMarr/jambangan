<?php

namespace App\Http\Livewire;

use Livewire\Component;
// use App\Models\Event;

class MockCalendar extends Component
{
    public $count = 1;
    //     $this->events = Event::all()->map(function ($event) {
    //         return [
    //             'id' => $event->id,
    //             'title' => $event->event_name,
    //             'start' => $event->event_date,
    //             'description' => $event->description,
    //         ];
    //     });

    //     $this->emit('eventsUpdated'); // Notify JavaScript that events are loaded

    public function render()
    {
        return view('livewire.mock-calendar');
    }
}
