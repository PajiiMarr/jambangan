<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Bookings;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use App\Models\Logs;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingsComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $tab = 'All';
    public $sortBy = 'start_date';
    public $sortSppStatus = 'preview';
    public $perPage = 10;
    public $selectedBooking = null;

    // Form properties
    public $name;
    public $email;
    public $phone;
    public $event_type;
    public $event_start_date;
    public $event_end_date;
    public $message;
    public $booking_id;

    public function mount()
    {
        $this->checkAndUpdateBookingStatuses();
    }

    private function checkAndUpdateBookingStatuses()
    {
        $today = now()->format('Y-m-d');
        
        // Update upcoming bookings that have passed their end date to completed
        Bookings::where('status', 'upcoming')
            ->where('event_end_date', '<', $today)
            ->update(['status' => 'completed']);
            
        // Update ongoing bookings that have passed their end date to completed
        Bookings::where('status', 'ongoing')
            ->where('event_end_date', '<', $today)
            ->update(['status' => 'completed']);
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

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'event_type' => 'required|string|max:255',
            'event_start_date' => 'required|date|after_or_equal:today',
            'event_end_date' => 'nullable|date|after_or_equal:event_start_date',
            'message' => 'nullable|string',
        ]);
    
        try {
            DB::beginTransaction();
            
            // Check for overlapping bookings
            $overlap = Bookings::where(function($query) {
                $query->where(function($q) {
                    // Check if new booking's start date falls within an existing booking
                    $q->whereDate('event_start_date', '<=', $this->event_start_date)
                      ->whereDate('event_end_date', '>=', $this->event_start_date);
                })->orWhere(function($q) {
                    // Check if new booking's end date falls within an existing booking
                    $q->whereDate('event_start_date', '<=', $this->event_end_date)
                      ->whereDate('event_end_date', '>=', $this->event_end_date);
                })->orWhere(function($q) {
                    // Check if new booking completely encompasses an existing booking
                    $q->whereDate('event_start_date', '>=', $this->event_start_date)
                      ->whereDate('event_end_date', '<=', $this->event_end_date);
                });
            })->exists();

            if ($overlap) {
                session()->flash('error', 'Cannot book these dates as they overlap with an existing booking. Please choose different dates.');
                return;
            }

            $bookings = Bookings::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'event_type' => $this->event_type,
                'event_start_date' => $this->event_start_date,
                'event_end_date' => $this->event_end_date,
                'message' => $this->message,
                'status' => 'pending',
            ]);
            
            session()->flash('success', 'Booking successfully saved.');

            DB::commit();
    
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
            
            // Emit event to refresh the calendar and bookings list
            $this->dispatch('booking-saved');
            $this->dispatch('bookingAdded');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding booking:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to create booking. Please try again.');
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
            'Pending' => Bookings::where('status', 'pending')->count(),
            'Completed' => Bookings::where('status', 'completed')->count(),
            'Ongoing' => Bookings::where('status', 'ongoing')->count(),
            'Upcoming' => Bookings::where('status', 'upcoming')->count(),
        ];

        // Determine the actual database column for sorting
        $sortField = match($this->sortBy) {
            'start_date' => 'event_start_date',
            'end_date' => 'event_end_date',
            'title' => 'name',
            default => 'event_start_date',
        };

        $bookings = Bookings::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            // Apply status filter unless 'All' is selected
            ->when($this->tab !== 'All', function ($query) {
                $query->where('status', strtolower($this->tab));
            })
            ->orderBy($sortField)
            ->paginate($this->perPage);

        $events = Bookings::all()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->name,
                'start' => $booking->event_start_date,
                'end' => \Carbon\Carbon::parse($booking->event_end_date)->addDay()->format('Y-m-d'),
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
            'pending' => '#f59e42',    // orange
            'upcoming' => '#3b82f6',   // blue
            'ongoing' => '#10b981',    // green
            'completed' => '#64748b',  // slate-500
            default => '#3b82f6',      // blue
        };
    }

    public function updateBooking($id)
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

        try {
            $booking = Bookings::find($id);
            if ($booking) {
                $booking->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'event_type' => $this->event_type,
                    'event_start_date' => $this->event_start_date,
                    'event_end_date' => $this->event_end_date,
                    'message' => $this->message,
                ]);

                session()->flash('success', 'Booking updated successfully.');
                $this->modal_close('edit-booking');
                $this->dispatch('booking-saved');
                $this->dispatch('bookingAdded');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update booking. Please try again.');
        }
    }

    public function deleteBooking($id)
    {
        try {
            $booking = Bookings::find($id);
            if ($booking) {
                $booking->delete();
                $this->selectedBooking = null;
                session()->flash('success', 'Booking deleted successfully.');
                $this->modal_close('delete-booking');
                $this->dispatch('booking-saved');
                $this->dispatch('bookingAdded');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete booking. Please try again.');
        }
    }

    public function getEvents()
    {
        return Bookings::all()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->name,
                'start' => $booking->event_start_date,
                'end' => Carbon::parse($booking->event_end_date)->addDay()->format('Y-m-d'),
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

    public function acceptBooking($id)
    {
        $booking = Bookings::find($id);
        if ($booking && $booking->status === 'pending') {
            $today = now()->format('Y-m-d');
            if ($booking->event_start_date == $today) {
                $booking->status = 'ongoing';
            } else {
                $booking->status = 'upcoming';
            }
            $booking->save();
            $this->selectedBooking = $booking;
            session()->flash('success', 'Booking accepted and set to ' . ucfirst($booking->status) . '.');
            $this->modal_close('booking-details');
            $this->dispatch('booking-saved');
            $this->dispatch('bookingAdded');
        }
    }

    public function rejectBooking($id)
    {
        $booking = Bookings::find($id);
        if ($booking && $booking->status === 'pending') {
            $booking->delete();
            $this->selectedBooking = null;
            session()->flash('success', 'Booking rejected and removed.');
            $this->modal_close('booking-details');
            $this->dispatch('booking-saved');
            $this->dispatch('bookingAdded');
        }
    }

    public function getBookedRanges()
    {
        return Bookings::all()->map(function ($b) {
            return [
                'start' => $b->event_start_date,
                'end' => $b->event_end_date
            ];
        })->values();
    }

    #[On('booking-saved')]
    public function handleBookingSaved()
    {
        // Refresh the bookings list and calendar
        $this->dispatch('booking-saved');
        $this->dispatch('bookingAdded');
    }
}
 