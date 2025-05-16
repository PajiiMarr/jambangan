<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bookings;
use Livewire\Attributes\Rule;

class PublicBookingsComponent extends Component
{
    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|email|max:255')]
    public $email = '';

    #[Rule('required|string|max:20')]
    public $phone = '';

    #[Rule('required|date|after:today')]
    public $event_start_date = '';
    public $event_end_date = '';

    #[Rule('required|string|max:255')]
    public $event_type = '';

    #[Rule('nullable|string|max:1000')]
    public $message = '';

    public $showSuccessMessage = false;

    public function saveBooking()
    {
        $this->validate();

        Bookings::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'event_start_date' => $this->event_start_date,
            'event_end_date' => $this->event_end_date,
            'event_type' => $this->event_type,
            'message' => $this->message,
            'status' => 'pending',
        ]);

        $this->reset(['name', 'email', 'phone', 'event_start_date', 'event_end_date', 'event_type', 'message']);
        
        // Set session flash message
        session()->flash('success', 'Booking request submitted successfully!');
        
        // Dispatch a global event for admin page refresh
        $this->dispatch('booking-saved')->to('bookings-component');
        
        // Redirect to the same page to refresh
        return redirect()->route('bookings-public');
    }

    public function modal_close($name)
    {
        $this->modal($name)->close();
    }

    public function render()
    {
        $bookings = Bookings::orderBy('created_at', 'desc')
            ->get();

        return view('livewire.public-bookings-component', [
            'bookings' => $bookings
        ]);
    }
} 