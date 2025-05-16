<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Bookings; // Correct model name
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use App\Models\Logs;
use App\Models\Performances;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class BookingsComponent extends Component
{
    use WithPagination;

    

    public $search = '';
    public $tab = 'Completed';
    public $sortBy = 'start_date';
    public $sortSppStatus = 'preview';
    public $perPage = 10;
    public $selectedBooking = null;
    public $selectedPerformanceName = 'Select Performance';
    public $selectedPerformance;

    // Form properties
    public $name;
    public $email;
    public $phone;
    public $event_type;
    public $event_start_date;
    public $event_end_date;
    public $message;
    public $booking_id;

    public $performances;

    public function mount(){
        $this->performances = Performances::all();
    }

    public function updatedSelectedPerformance($value)
    {
        if ($value == "none"){
            $this->selectedPerformanceName = "None";
            $this->selectedPerformance = null;
            return;
        }

        if ($value) {
            $performance = Performances::find($value);
            $this->selectedPerformanceName = $performance ? $performance->title : 'Select Performance';
        } else {
            $this->selectedPerformanceName = 'Select Performance';
        }
    }

    #[On('dateClick')]
    public function dateClick($data)
    {
        $this->event_start_date = date('Y-m-d', strtotime($data['start']));
        $this->event_end_date = date('Y-m-d', strtotime($data['end']));
    }


    public function eventClick($id)
    {
        $booking = Bookings::find($id);
        if ($booking) {
            $this->booking_id = $booking->id;
            $this->selectedBooking = $booking;
            $this->name = $booking->name;
            $this->email = $booking->email;
            $this->phone = $booking->phone;
            $this->event_type = $booking->event_type;
            $this->event_start_date = $booking->event_start_date;
            $this->event_end_date = $booking->event_end_date;
            $this->message = $booking->message;

            $this->modal('booking-details')->show();
        }
    }

    public function getEvents()
    {
        return Bookings::all()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->name,
                'start' => $booking->event_start_date,
                'end' => $booking->event_end_date,
                'color' => $this->getStatusColor($booking->status),
                'extendedProps' => [
                    'email' => $booking->email,
                    'phone' => $booking->phone,
                    'event_type' => $booking->event_type,
                    'status' => $booking->status,
                    'message' => $booking->message,
                ]
            ];
        })->toArray();
    }


    

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'event_type' => 'required|string|max:255',
            'event_start_date' => 'required|date',
            'event_end_date' => 'nullable|date|after_or_equal:event_start_date',
            'message' => 'nullable|string',
        ]);

        Log::debug($this->event_end_date . ' ' . $this->event_start_date);
    
        try {
            DB::beginTransaction();
            $bookings = Bookings::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'event_type' => $this->event_type,
                'event_start_date' => $this->event_start_date,
                'event_end_date' => $this->event_end_date,
                'message' => $this->message,
                'performance_id' => $this->selectedPerformance
            ]);
            
            session()->flash('success', 'Booking successfully saved.');

            DB::commit();

            $this->dispatch('bookingAdded'); // Add this line to dispatch an event

    
            Logs::create([
                'user_id' => Auth::id(),
                'action' => 'Added a booking',
                'navigation' => 'bookings',
                'booking_id' => $bookings->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->resetFormFields();
            $this->modal_close('booking-modal');
        } catch (\Exception $e) {
            Log::error('Error adding booking:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to publish performance. Please try again.');
        }
    }

    private function resetFormFields()
    {
        $this->name = null;
        $this->email = null;
        $this->phone = null;
        $this->event_type = null;
        $this->event_start_date = null;
        $this->event_end_date = null;
        $this->message = null;
    }

    public function modal_close($name){
        $this->modal($name)->close();
    }

    public function render()
    {
        $statusCounts = [
            'Completed' => Bookings::where('status', 'completed')->count(),
            'Ongoing' => Bookings::where('status', 'ongoing')->count(),
            'Upcoming' => Bookings::where('status', 'upcoming')->count(),
        ];

        $bookings = Bookings::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            // ->when($this->tab, function ($query) {
            //     $query->where('status', strtolower($this->tab));
            // })
            ->orderBy($this->sortBy)
            ->paginate($this->perPage);


        $events = Bookings::all()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->name,
                'start' => $booking->event_start_date,
                'end' => $booking->event_end_date,
                'color' => $this->getStatusColor($booking->status),
                'extendedProps' => [
                    'email' => $booking->email,
                    'phone' => $booking->phone,
                    'event_type' => $booking->event_type,
                    'status' => $booking->status,
                    'message' => $booking->message,
                ]
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
            'upcoming' => '#3b82f6',
            'ongoing' => '#10b981',
            'completed' => '#6b7280',
            default => '#3b82f6',
        };
    }
}
 