<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class BookingsComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $tab = 'Completed';
    public $sortBy = 'event_date';
    public $perPage = 10;
    public $selectedBooking = null;
    public $showModal = false;

    public $name;
    public $email;
    public $phone;
    public $event_date;
    public $event_type;
    public $message;

    protected $listeners = [
        'eventClick',
        'dateClick',
        'booking-operation-successful' => '$refresh',
    ];

    public function mount()
    {
        $this->event_date = null;
    }

    public function eventClick($eventInfo)
    {
        $bookingId = null;
        if (is_array($eventInfo) && isset($eventInfo['id'])) {
            $bookingId = $eventInfo['id'];
        } elseif (is_object($eventInfo) && isset($eventInfo->id)) {
            $bookingId = $eventInfo->id;
        }

        if ($bookingId) {
            $this->selectedBooking = Booking::find($bookingId);
            if ($this->selectedBooking) {
                $this->name = $this->selectedBooking->name;
                $this->email = $this->selectedBooking->email;
                $this->phone = $this->selectedBooking->phone;
                $this->event_date = $this->selectedBooking->event_date instanceof \Carbon\Carbon
                                    ? $this->selectedBooking->event_date->format('Y-m-d')
                                    : $this->selectedBooking->event_date;
                $this->event_type = $this->selectedBooking->event_type;
                $this->message = $this->selectedBooking->message;
            }
        }
    }

    public function viewBooking($bookingId)
    {
        $this->selectedBooking = Booking::find($bookingId);
        $this->dispatch('open-modal', 'booking-modal');
    }

    public function updatedSelectedBooking($value)
    {
        if (is_array($value)) {
            $bookingId = $value[1]['key'] ?? null;
            if ($bookingId) {
                $this->selectedBooking = Booking::find($bookingId);
            }
        } elseif (is_numeric($value)) {
            $this->selectedBooking = Booking::find($value);
        } else {
            $this->selectedBooking = null;
        }
    }

    public function dateClick($date)
    {
        $this->event_date = date('Y-m-d', strtotime($date));
    }

    public function save()
    {
        try {
            $validated = $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'event_date' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) {
                        if (strtotime($value) <= strtotime(now()->format('Y-m-d'))) {
                            $fail('The event date must be a future date.');
                        }
                    },
                ],
                'event_type' => 'required|string|max:255',
                'message' => 'nullable|string'
            ]);

            if ($this->selectedBooking && $this->selectedBooking->id) {
                $booking = Booking::find($this->selectedBooking->id);
                if ($booking) {
                    $booking->update($validated);
                }
            } else {
                $validated['status'] = 'upcoming';
                Booking::create($validated);
            }

            $this->resetForm();
            $this->closeModal();
            session()->flash('message', 'Booking saved successfully!');

            $freshEvents = $this->getCalendarEvents();
            $this->dispatch('booking-operation-successful', events: $freshEvents);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', 'Validation failed: ' . implode(', ', array_map(function($arr) { return implode(', ', $arr); }, $e->errors())));
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving booking: ' . $e->getMessage());
        }
    }

    protected function resetForm()
    {
        $this->reset(['name', 'email', 'phone', 'event_date', 'event_type', 'message', 'selectedBooking']);
        $this->event_date = null;
    }

    public function closeModal()
    {
        $this->selectedBooking = null;
        $this->dispatch('close-modal', 'booking-modal');
    }
    
    protected function getCalendarEvents()
    {
        return Booking::all()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->name,
                'start' => $booking->event_date instanceof \Carbon\Carbon ? $booking->event_date->format('Y-m-d') : $booking->event_date,
                'end' => $booking->event_date instanceof \Carbon\Carbon ? $booking->event_date->format('Y-m-d') : $booking->event_date,
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

    public function updateStatus($bookingId, $newStatus)
    {
        try {
            $booking = Booking::find($bookingId);
            if ($booking) {
                $booking->update(['status' => $newStatus]);
                session()->flash('message', 'Booking status updated successfully!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating booking status: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Get status counts
        $statusCounts = [
            'Completed' => Booking::where('status', 'completed')->count(),
            'Ongoing' => Booking::where('status', 'ongoing')->count(),
            'Upcoming' => Booking::where('status', 'upcoming')->count(),
        ];

        // Build the query
        $query = Booking::query();

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('event_type', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter - make it case insensitive
        if ($this->tab) {
            $query->whereRaw('LOWER(status) = ?', [strtolower($this->tab)]);
        }

        // Apply sorting
        $query->orderBy($this->sortBy, 'desc');

        // Get paginated results
        $bookings = $query->paginate($this->perPage);

        // Get calendar events
        $events = $this->getCalendarEvents();

        // Debug information
        \Log::info('Bookings Query:', [
            'search' => $this->search,
            'tab' => $this->tab,
            'sortBy' => $this->sortBy,
            'perPage' => $this->perPage,
            'bookings_count' => $bookings->count(),
            'total_bookings' => $bookings->total(),
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        return view('livewire.bookings-component', [
            'statusCounts' => $statusCounts,
            'bookings' => $bookings,
            'events' => $events,
        ]);
    }

    private function getStatusColor($status)
    {
        return match(strtolower($status ?? '')) {
            'upcoming' => '#3b82f6', 
            'ongoing' => '#10b981',   
            'completed' => '#6b7280',  
            default => '#3b82f6',
        };
    }

    public function handleModalClose($modalName){
        $this->resetForm();
        $this->dispatch('js-close-flux-modal', name: $modalName);
    }
}