<?php
namespace App\Livewire;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Events;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Logs;

class Calendar extends Component
{
    use WithFileUploads;
    use WithPagination;
    
    public $tab = 'Completed'; 
    public $statusCounts = [
        'Completed' => 0,
        'Ongoing' => 0,
        'Upcoming' => 0,
    ];
    public $events = [];
    public $fileUpload;

    public function mount()
    {
        $this->loadEvents();
    }

    public function updatedTab()
    {
        $this->resetPage(); // resets to page 1 when switching tabs
    }

    public function getSortedEventsProperty()
    {
        return Events::with(['media' => function($query) {
                $query->where('type', 'image');
            }])
            ->where('status', $this->tab)
            ->orderBy('start_date', 'asc')
            ->paginate(4)
            ->through(function ($event) {
                // Append the first media's file_data directly to the event
                $media = $event->media;
                $event->file_data = $media ? $media->file_data : null;
                \Log::info('Media:', ['media' => $event->media]);
                return $event;
            });
    }

    

    public function loadEvents()
    {
        try {
            $query = Events::with(['media' => function($query) {
                $query->where('type', 'image');
            }])->select(
                'event_id as id',
                'event_name as title',
                'start_date as start',
                'end_date as end',
                'location',
                'status',
                'event_id',
                'file_data',
                'media_id',
                'type',
                'uploaded_at',
                // Make sure to include the actual event_id column
            );

            $events = $query->get();
            
            $this->events = $events->map(function($event) {
                // Check if media relationship exists and has items before trying to access first()
                $media = $event->media && $event->media->count() > 0 ? $event->media->first() : null;
                
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start,
                    'end' => $event->end,
                    'location' => $event->location,
                    'status' => $event->status,
                    'cover_photo' => $media ? $media->file_data : null,
                    'media_id' => $media ? $media->media_id : null,
                    'media_type' => $media ? $media->type : null
                ];
            })->toArray();

            $this->statusCounts = [
                'Completed' => Events::where('status', 'Completed')->count(),
                'Ongoing' => Events::where('status', 'Ongoing')->count(),
                'Upcoming' => Events::where('status', 'Upcoming')->count(),
            ];
            
            Log::info('Events loaded successfully', ['count' => count($this->events)]);
        } catch (Exception $e) {
            Log::error('Error loading events', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->events = []; // Ensure events is always an array even on failure
        }
    }

    public function openEventModal($eventId)
    {
        $event = Events::with(['media' => function($query) {
                $query->where('type', 'image');
            }])
            ->select(
                'event_id as id',
                'event_name as title',
                'start_date as start',
                'end_date as end',
                'location',
                'status'
            )
            ->find($eventId);

        if ($event) {
            // Add media data to event for the modal
            $media = $event->media && $event->media->count() > 0 ? $event->media->first() : null;
            $eventData = $event->toArray();
            $eventData['cover_photo'] = $media ? $media->file_data : null;
            $eventData['media_id'] = $media ? $media->media_id : null;
            
            $this->dispatch('view-event-modal-trigger', $eventData);
        }
    }

    #[On('addEvent')]
    public function addEvent($title, $start, $end, $location){
        try {
            Log::info('Starting event creation process', [
                'title' => $title,
                'start' => $start,
                'end' => $end,
                'location' => $location,
                'user_id' => Auth::user()->id
            ]);

            DB::beginTransaction();
            Log::info('Database transaction started');

            $status = $this->getEventStatus($start, $end);
            Log::info('Event status determined', ['status' => $status]);

            $event = Events::create([
                    'event_name' => $title,
                    'start_date' => $start,
                    'end_date' => $end,
                    'location' => $location,
                    'status' => $status,
                    'user_id' => Auth::user()->id,
                ]);
            
            Log::info('Event created successfully', [
                'event_id' => $event->event_id,
                'event_name' => $event->event_name
            ]);

            if ($this->fileUpload) {
                Log::info('File upload detected, processing media', [
                    'file_name' => $this->fileUpload->getClientOriginalName(),
                    'file_size' => $this->fileUpload->getSize(),
                    'file_type' => $this->fileUpload->getMimeType()
                ]);
            
                $path = $this->fileUpload->store(
                    'uploads',
                    's3'
                );

                $media = Media::create([
                    'event_id' => $event->event_id,
                    'file_data' => $path,
                    'type' => 'image',
                ]);

                Log::info('Media record created', [
                    'media_id' => $media->media_id,
                    'event_id' => $media->event_id
                ]);
            }

            DB::commit();
            Log::info('Database transaction committed successfully');

            $this->loadEvents();
            Log::info('Events reloaded after creation');

            Logs::create([
                'action' => 'Created an event',
                'navigation' => 'events',
                'user_id' => Auth::user()->id,
                'event_id' => $event->event_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->dispatch('eventLoaded', events: $this->events);
            $this->dispatch('close-modal', id: 'add-event');
            
            Log::info('Event creation process completed successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Event creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            // You might want to dispatch an error event to the frontend
            $this->dispatch('event-creation-failed', [
                'message' => 'Failed to create event: ' . $e->getMessage()
            ]);
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
                'event_name' => $data['title'] ?? $event->event_name,
                'location' => $data['location'] ?? $event->location,
                'start_date' => $data['start'] ?? $event->start_date,
                'end_date' => $data['end'] ?? $event->end_date,
                'status' => $status,
                'user_id' => Auth::user()->id,
            ]);

            Logs::create([
                'action' => 'Updated an event',
                'navigation' => 'events',
                'user_id' => Auth::user()->id,
                'event_id' => $event->event_id,
                'created_at' => now(),
                'updated_at' => now(),
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
            
            $this->dispatch('close-modal', id: 'edit-event');
        } catch (Exception $e) {
            Log::error('Event update failed: ' . $e->getMessage());
            $this->dispatch('event-update-failed', [
                'message' => 'Failed to update event: ' . $e->getMessage()
            ]);
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
            'events' => $this->events,
            'sortedEvents' => $this->getSortedEventsProperty(),

        ]);
    }
}