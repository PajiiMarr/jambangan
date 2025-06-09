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
    
    public $tab; 
    public $statusCounts = [
        'Completed' => 0,
        'Ongoing' => 0,
        'Upcoming' => 0,
    ];
    public $events = [];
    public $fileUpload;
    public $search = '';
    public $sortBy = 'start_date';
    public $sortDirection = 'asc';
    public $sortSppStatus = 'preview';
    public $dateFilter;
    public $perPage = 10;
    public $lastSavedEventId;
    public $editFileUpload; // Add this property

    public function mount()
    {
        $this->loadEvents();
    }

    public function updatedTab()
    {
        $this->resetPage(); // resets to page 1 when switching tabs
        $this->loadEvents(); // Reload events when tab changes
    }

    // Add these methods to reload events when filters change
    public function updatedSearch()
    {
        $this->resetPage();
        $this->loadEvents();
    }

    public function updatedSortBy()
    {
        $this->loadEvents();
    }

    public function updatedSortSppStatus()
    {
        $this->resetPage();
        $this->loadEvents();
    }

    public function getSortedEventsProperty()
    {
        $query = Events::with(['media' => function($query) {
                $query->where('type', 'image');
            }]);
        
        if ($this->tab) {
            $query->where('status', $this->tab);
        }
        
        return $query
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('event_name', 'like', '%'.$this->search.'%')
                    ->orWhere('location', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->sortSppStatus, function ($query) {
                $query->where(function($q) {
                    $q->where('spp_status', $this->sortSppStatus);
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage)
            ->through(function ($event) {
                return [
                    'event_id' => $event->event_id,
                    'title' => $event->event_name,
                    'location' => $event->location,
                    'start' => $event->start_date,
                    'end' => $event->end_date,
                    'status' => $event->status,
                    'file_data' => $event->media ? Storage::url($event->media->file_data) : null,
                    'spp_status' => $event->spp_status
                ];
            });
    }

    public function loadEvents()
    {
        try {
            // Get all events or filtered events based on current filters
            $eventsQuery = Events::with(['media' => function($query) {
                $query->where('type', 'image');
            }]);

            // Apply the same filters as getSortedEventsProperty for consistency
            if ($this->search) {
                $eventsQuery->where(function($q) {
                    $q->where('event_name', 'like', '%'.$this->search.'%')
                      ->orWhere('location', 'like', '%'.$this->search.'%');
                });
            }

            if ($this->sortSppStatus) {
                $eventsQuery->where('spp_status', $this->sortSppStatus);
            }

            $events = $eventsQuery->get();
            
            $this->events = $events->map(function($event) {
                $media = $event->media;
                
                return [
                    'id' => $event->event_id,
                    'title' => $event->event_name,
                    'start' => $event->start_date,
                    'end' => $event->end_date,
                    'location' => $event->location,
                    'status' => $event->status,
                    'file_data' => $media ? Storage::url($media->file_data) : null,
                    'allDay' => true, // Add this line to ensure all events are treated as all-day
                    'extendedProps' => [
                        'status' => $event->status,
                        'location' => $event->location,
                        'file_data' => $media ? Storage::url($media->file_data) : null,
                        'spp_status' => $event->spp_status,
                    ],
                    'spp_status' => $event->spp_status
                ];
            })->toArray();

            $this->statusCounts = [
                'Completed' => Events::where('status', 'Completed')->count(),
                'Ongoing' => Events::where('status', 'Ongoing')->count(),
                'Upcoming' => Events::where('status', 'Upcoming')->count(),
            ];

            $this->dispatch('eventsLoaded', events: $this->events);
            
            Log::info('Events loaded successfully', ['count' => count($this->events)]);
        } catch (Exception $e) {
            Log::error('Error loading events', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->events = [];
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

            $status = $this->getEventStatus($start, $end);

            $event = Events::create([
                    'event_name' => $title,
                    'start_date' => $start,
                    'end_date' => $end,
                    'location' => $location,
                    'status' => $status,
                    'user_id' => Auth::user()->id,
                ]);
            
            if ($this->fileUpload) {
                $path = $this->fileUpload->store(
                    'uploads',
                    's3'
                );

                $media = Media::create([
                    'event_id' => $event->event_id,
                    'file_data' => $path,
                    'type' => 'image',
                ]);
            }

            DB::commit();

            $this->loadEvents();

            $this->dispatch('eventsLoaded', events: $this->events);

            Logs::create([
                'action' => 'Created an event',
                'navigation' => 'events',
                'user_id' => Auth::user()->id,
                'event_id' => $event->event_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->lastSavedEventId = $event->event_id;

            $this->modal('add-event')->close();
            $this->modal('spp-confirmation')->show();

            $this->dispatch('eventLoaded', events: $this->events);
            $this->dispatch('close-flux-modal', ['name' => 'add-event']);
            
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Event creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            $this->dispatch('event-creation-failed', [
                'message' => 'Failed to create event: ' . $e->getMessage()
            ]);
        }
    }

    #[On('publishEvent')]
    public function publishEvent($data = []){
        try {
            $event = Events::find($data['id']);

            if (!$event) {
                throw new Exception('Event not found.');
            }

            $event->update([
                'spp_status' => 'publish',
                'event_id' => $data['id'],
            ]);

            Logs::create([
                'action' => 'Published an event',
                'navigation' => 'events',
                'user_id' => Auth::user()->id,
                'event_id' => $event->event_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->loadEvents();
            $this->modal('publish-event')->close();

        } catch (Exception $e) {
            Log::error('Publish update failed: ' . $e->getMessage());
            $this->dispatch('event-update-failed', [
                'message' => 'Failed to update event: ' . $e->getMessage()
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
    
            DB::beginTransaction();
    
            $event->update([
                'event_name' => $data['title'] ?? $event->event_name,
                'location' => $data['location'] ?? $event->location,
                'start_date' => $data['start'] ?? $event->start_date,
                'end_date' => $data['end'] ?? $event->end_date,
                'status' => $status,
                'user_id' => Auth::user()->id,
            ]);
    
            // Handle file upload if a new file was provided
            if ($this->editFileUpload) {
                // Delete old media if it exists
                $oldMedia = Media::where('event_id', $event->event_id)->first();
                if ($oldMedia) {
                    Storage::disk('s3')->delete($oldMedia->file_data);
                    $oldMedia->delete();
                }
    
                // Store new file
                $path = $this->editFileUpload->store('uploads', 's3');
    
                Media::create([
                    'event_id' => $event->event_id,
                    'file_data' => $path,
                    'type' => 'image',
                ]);
            }
    
            DB::commit();
    
            Logs::create([
                'action' => 'Updated an event',
                'navigation' => 'events',
                'user_id' => Auth::user()->id,
                'event_id' => $event->event_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            $this->loadEvents();
            $this->dispatch('eventsLoaded', events: $this->events);
            $this->modal('view-event')->close();
            $this->modal_close('edit-event');
            
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Event update failed: ' . $e->getMessage());
            $this->dispatch('event-update-failed', [
                'message' => 'Failed to update event: ' . $e->getMessage()
            ]);
        }
    }

    #[On('deleteEvent')]
    public function deleteEvent($data = [])
    {
        try {
            $event = Events::findOrFail($data['id']);
            $event->delete();
            
            $this->dispatch('event-deleted', message: 'Event successfully deleted.');
            
            $this->events;
            $this->modal('delete-event')->close();
            $this->modal('view-event')->close();

            $this->loadEvents();

            $this->dispatch('eventsLoaded', events: $this->events);
        } catch (\Exception $e) {
            $this->dispatch('event-delete-error', message: 'Error deleting event: ' . $e->getMessage());
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

    public function spp_status_save(){
        try {
            $event = Events::find($this->lastSavedEventId);
            $event->spp_status = 'publish';
            $event->save();
            $this->modal('spp-confirmation')->close();
        } catch (\Exception $e) {
            Log::error('Error updating spp_status:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to publish performance. Please try again.');
        }
    }

    public function modal_close($modal_name)
    {
        $this->modal($modal_name)->close();
        $this->dispatch('modalClosed', modalName: $modal_name);
    }

    public function render()
    {
        $this->loadEvents();
        
        return view('livewire.calendar',[
            'events' => $this->events,
            'sortedEvents' => $this->getSortedEventsProperty(),
        ]);
    }
}