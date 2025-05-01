<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class BookingsComponent extends Component
{
    use WithPagination;
    
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showModal = false;
    public $showViewModal = false;
    public $editingBooking = null;
    public $viewingBooking = null;

    protected $listeners = ['booking-created' => '$refresh'];

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

    public function mount()
    {
        $this->viewingBooking = null;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function openModal()
    {
        $this->reset(['name', 'email', 'phone', 'event_date', 'event_type', 'message', 'editingBooking']);
        $this->showModal = true;
    }

    public function viewBooking(Booking $booking)
    {
        $this->viewingBooking = $booking;
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewingBooking = null;
    }

    public function editBooking(Booking $booking)
    {
        $this->editingBooking = $booking;
        $this->name = $booking->name;
        $this->email = $booking->email;
        $this->phone = $booking->phone;
        $this->event_date = $booking->event_date->format('Y-m-d');
        $this->event_type = $booking->event_type;
        $this->message = $booking->message;
        $this->showModal = true;
    }

    public function saveBooking()
    {
        $this->validate();

        if ($this->editingBooking) {
            $this->editingBooking->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'event_date' => $this->event_date,
                'event_type' => $this->event_type,
                'message' => $this->message,
            ]);
            session()->flash('message', 'Booking updated successfully.');
        } else {
            Booking::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'event_date' => $this->event_date,
                'event_type' => $this->event_type,
                'message' => $this->message,
                'status' => 'pending',
            ]);
            session()->flash('message', 'Booking created successfully.');
        }

        $this->showModal = false;
        $this->reset(['name', 'email', 'phone', 'event_date', 'event_type', 'message', 'editingBooking']);
    }

    public function deleteBooking(Booking $booking)
    {
        $booking->delete();
        session()->flash('message', 'Booking deleted successfully.');
    }

    public function updateStatus(Booking $booking, $status)
    {
        $booking->update(['status' => $status]);
        session()->flash('message', 'Booking status updated successfully.');
    }

    public function render()
    {
        $bookings = Booking::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('event_type', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.bookings-component', [
            'bookings' => $bookings
        ]);
    }
}
