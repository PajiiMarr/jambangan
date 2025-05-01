<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
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
    public $event_date = '';

    #[Rule('required|string|max:255')]
    public $event_type = '';

    #[Rule('nullable|string|max:1000')]
    public $message = '';

    public $showSuccessMessage = false;

    public function saveBooking()
    {
        $this->validate();

        Booking::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'event_date' => $this->event_date,
            'event_type' => $this->event_type,
            'message' => $this->message,
            'status' => 'pending',
        ]);

        $this->reset(['name', 'email', 'phone', 'event_date', 'event_type', 'message']);
        
        // Set session flash message
        session()->flash('success', 'Booking request submitted successfully!');
        
        // Redirect to the same page to refresh
        return redirect()->route('bookings-public');
    }

    public function render()
    {
        return view('livewire.public-bookings-component');
    }
} 