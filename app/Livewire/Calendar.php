<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Events;
use Illuminate\Support\Facades\Auth;
use Exception;

class Calendar extends Component
{
    public $events;

    public function mount()
    {
        $this->loadEvents();
    }

    public function loadEvents (){
        $this->events = Events::select('event_id as id',
            'event_name as title',
            'start_date as start',
            'end_date as end',
            'location',
            'status',
        )->get()->toArray();
    }

    #[On('addEvent')]
    public function addEvent($title, $start, $end, $location){
        try {
            $status = $this->getEventStatus($start, $end);

            Events::create([
                    'event_name' => $title,
                    'start_date' => $start,
                    'end_date' => $end,
                    'location' => $location,
                    'status' => $status,
                    'user_id' => Auth::user()->id,
                ]);

            $this->loadEvents();
            $this->dispatch('eventLoaded', events: $this->events);
            $this->modal('add-event')->close();
            } catch (Exception $e) {
            Log::error('Event creation failed: ' . $e->getMessage());
        }
    }

    #[On('updateEvent')]
    public function updateEvent($data = [])
    {
        try {
            $event = Events::find($data['id']);

            if (!$event) {
                throw new Exception('Event not found.');
            }

            $status = $this->getEventStatus($data['start'] ?? $event->start_date, $data['end'] ?? $event->end_date);

            $event->update([
                'event_id' => $data['id'],
                'event_name' => $data['title'] ?? $event->event_name,
                'location' => $data['location'] ?? $event->location,
                'start_date' => $data['start'] ?? $event->start_date,
                'end_date' => $data['end'] ?? $event->end_date,
                'status' => $status,
                'user_id' => Auth::user()->id,
            ]);

            $this->loadEvents();
            $this->dispatch('eventLoaded', events: $this->events);
            $this->dispatch('eventUpdated', [
                'id' => $event->event_id,
                'title' => $event->event_name,
                'location' => $event->location,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'status' => $event->status,
            ]);
            
            $this->modal('edit-event')->close();
        } catch (Exception $e) {
            Log::error('Event update failed: ' . $e->getMessage());
        }
    }



    private function getEventStatus($start, $end)
    {
        $today = now()->format('Y-m-d');

        if ($end < $today) {
            return 'Completed';
        } elseif ($start <= $today && $end >= $today) {
            return 'Ongoing';
        } else {
            return 'Upcoming';
        }
    }

    public function render()
    {
        return view('livewire.calendar',[
            'events' => $this->events
        ]);
    }
}
