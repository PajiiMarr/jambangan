<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Livewire\WithPagination;

class BookingsComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $tab = 'Completed';
    public $sortBy = 'start_date';
    public $sortSppStatus = 'preview';
    public $perPage = 10;
    public $selectedBooking = null;

    protected $listeners = ['eventClick', 'dateClick'];

    public function eventClick($event)
    {
        $this->selectedBooking = Booking::find($event['id']);
    }

    public function dateClick($date)
    {
        // Handle date click if needed
    }

    public function render()
    {
        $statusCounts = [
            'Completed' => Booking::where('status', 'completed')->count(),
            'Ongoing' => Booking::where('status', 'ongoing')->count(),
            'Upcoming' => Booking::where('status', 'upcoming')->count(),
        ];

        $bookings = Booking::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->tab, function ($query) {
                $query->where('status', strtolower($this->tab));
            })
            ->orderBy($this->sortBy)
            ->paginate($this->perPage);

        $events = Booking::all()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->name . ' - ' . $booking->event_type,
                'start' => $booking->start_date->toIso8601String(),
                'end' => $booking->end_date ? $booking->end_date->toIso8601String() : null,
                'color' => $this->getStatusColor($booking->status),
            ];
        })->toArray();

        return view('livewire.bookings-component', [
            'statusCounts' => $statusCounts,
            'bookings' => $bookings,
            'events' => $events,
        ]);
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'upcoming' => '#3b82f6', // blue
            'ongoing' => '#10b981',   // emerald
            'completed' => '#6b7280',  // gray
            default => '#3b82f6',
        };
    }
}