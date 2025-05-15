<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Performances;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Logs;


class PerformancesUi extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Add performance variables
    public $add_title;
    public $add_description;
    public $add_performance_file;
    public $publish_peformance_id;

    // Edit performance variables
    public $edit_title;
    public $edit_description;
    public $edit_performance_file;

    public $perPage = 10;
    public $selectedPerformance;
    public $editingPerformance;
    public $isEditing = false;

    // Sorting and filtering properties
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $sortSppStatus = 'preview';
    public $statusFilter = '';

    public $lastSavedPerformanceId;

    protected $rules = [
        'add_title' => 'required|min:3',
        'add_description' => 'nullable',
        'add_performance_file' => 'nullable|image|max:10240', // 10MB Max
        'edit_title' => 'required|min:3',
        'edit_description' => 'nullable',
        'edit_performance_file' => 'nullable|image|max:10240', // 10MB Max
    ];
    

    public function mount() {
        $this->add_title = '';
        $this->add_description = '';
        $this->edit_title = '';
        $this->edit_description = '';
        $this->isEditing = false;
        $this->selectedPerformance;
    }

    #[On('performance-added')]
    public function handlePerformanceAdded($performance = null)
    {
        $this->resetPage();
        
        if ($performance) {
            $this->showPerformance($performance['performance_id']);
        }
    }

    public function save()
    {
        $this->validate([
            'add_title' => 'required|min:3',
            'add_description' => 'nullable',
            'add_performance_file' => 'nullable|image|max:10240',
        ]);

        $performance = Performances::create([
            'title' => $this->add_title,
            'description' => $this->add_description,
        ]);

        if ($this->add_performance_file) {
            $path = $this->add_performance_file->store('uploads', 's3');
            $url = Storage::url($path); 
            $performance->media()->create([
                'performance_id' => $performance->performance_id,
                'file_data' => $path,
                'type' => 'image',
            ]);
        }

        Logs::create([
            'user_id' => Auth::id(),
            'action' => 'Added a new performance',
            'navigation' => 'performances',
            'performance_id' => $performance->performance_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->lastSavedPerformanceId = $performance->performance_id;

        $this->modal('add-performance')->close();
        $this->modal('spp-confirmation')->show();
        $this->reset(['add_title', 'add_description', 'add_performance_file']);
        $this->dispatch('performance-added');
    }

    public function showPerformance($id = null)
    {
        Log::debug('showPerformance called with ID:', ['id' => $id]);
        if (!$id) return;
        
        $this->selectedPerformance = Performances::with('media')->find($id);
        Log::debug('Selected Performance:', ['performance' => $this->selectedPerformance]);
    }

    public function editPerformance($id)
    {
        $this->editingPerformance = Performances::with('media')->find($id);
        
        if ($this->editingPerformance) {
            $this->edit_title = $this->editingPerformance->title;
            $this->publish_peformance_id = $this->editingPerformance->performance_id;
            $this->edit_description = $this->editingPerformance->description;
            $this->isEditing = true;
            $this->edit_performance_file = null;
            
            $this->dispatch('refresh-edit-form');
        }

        
    }

    public function openEditModal($id)
    {
        $this->editPerformance($id);
    }

    public function publish_performance($id){
        try {
            $performance = Performances::find($id);
            $performance->spp_status = 'publish';
            $performance->save();

            Logs::create([
                'user_id' => Auth::id(),
                'action' => 'Published a performance',
                'navigation' => 'performances',
                'performance_id' => $performance->performance_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->modal('publish')->close();

        } catch (\Exception $e) {
            Log::error('Error updating spp_status:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to publish performance. Please try again.');
        }
    }

    public function updatePerformance()
    {
        $this->validate([
            'edit_title' => 'required|min:3',
            'edit_description' => 'nullable',
            'edit_performance_file' => 'nullable|image|max:10240',
        ]);

        try {
            if (!$this->editingPerformance) {
                throw new \Exception("No performance selected for editing");
            }

            $this->editingPerformance->update([
                'title' => $this->edit_title,
                'description' => $this->edit_description,
            ]);

            if ($this->edit_performance_file) {
                // Delete old media if exists
                if ($this->editingPerformance->media) {
                    $this->editingPerformance->media->delete();
                }

                // Store new media
                $path = $this->edit_performance_file->store('uploads', 's3');
                $url = Storage::url($path);
                $this->editingPerformance->media()->create([
                    'performance_id' => $this->editingPerformance->performance_id,
                    'file_data' => $path,
                    'type' => 'image',
                ]);
            }

            // Store the ID before resetting
            $performanceId = $this->editingPerformance->performance_id;

            Logs::create([
                'user_id' => Auth::id(),
                'action' => 'Updated performance',
                'navigation' => 'performances',
                'performance_id' => $performanceId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->showPerformance($performanceId);
            
            // Reset the properties
            $this->reset(['edit_title', 'edit_description', 'edit_performance_file', 'isEditing', 'editingPerformance']);
            
            // Close the modal using the stored ID
            $this->modal('edit-performance-' . $performanceId)->close();
            
            $this->dispatch('performance-updated');
            session()->flash('message', 'Performance updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating performance:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to update performance. Please try again.');
        }
    }

    public function deletePerformance($id)
    {
        try {
            $performance = Performances::find($id);
            
            if ($performance) {
                // Delete associated media
                if ($performance->media) {
                    $performance->media->delete();
                }

                
                // Soft delete the performance
                $performance->delete();
                Logs::created([
                    'user_id' => Auth::id(),
                    'action' => 'Deleted performance',
                    'navigation' => 'performances',
                    'performance_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                $this->showPerformance($id);
                
                $this->dispatch('performance-deleted');
                $this->modal('delete-performance')->close();
                session()->flash('message', 'Performance deleted successfully!');
            }
        } catch (\Exception $e) {
            Log::error('Error deleting performance:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to delete performance. Please try again.');
        }
    }

    public function cancelEdit()
    {
        $this->reset(['edit_title', 'edit_description', 'edit_performance_file', 'isEditing', 'editingPerformance']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function updatedSortDirection()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function modal_close($modal_name){
        $this->modal($modal_name)->close();
    }

    public function closeModal($modalName)
    {
        $this->modal($modalName)->close();
    }

    public function spp_status_save($id){
        try {
            $performance = Performances::find($id);
            $performance->spp_status = 'publish';
            $performance->save();


            Logs::create([
                'user_id' => Auth::id(),
                'action' => 'Published a performance',
                'navigation' => 'performances',
                'performance_id' => $performance->performance_id,
                'created_at' => now(),
                'updated_at' => now(),
        ]);

            $this->modal('spp-confirmation')->close();
        } catch (\Exception $e) {
            Log::error('Error updating spp_status:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to publish performance. Please try again.');
        }
    }

    public function render()
    {
        $query = Performances::with('media')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->sortSppStatus, function ($query) {
                $query->where('spp_status', $this->sortSppStatus);
            })
            ->orderBy($this->sortBy, $this->sortDirection);

            $this->selectedPerformance;

        $performances = $query->paginate($this->perPage);

        if (!$this->selectedPerformance && $performances->isNotEmpty()) {
            $this->selectedPerformance = $performances->first();
        }

        $totalPerformances = Performances::count();
        $activePerformances = Performances::where('status', 'active')->count();
        $inactivePerformances = Performances::where('status', 'inactive')->count();
        $upcomingShows = Performances::where('status', 'active')->count(); // For now, using active performances as upcoming shows

        return view('livewire.performances-ui',
            [
                'performances' => $performances,
                'selectedPerformance' => $this->selectedPerformance,
                'totalPerformances' => $totalPerformances,
                'activePerformances' => $activePerformances,
                'inactivePerformances' => $inactivePerformances,
                'upcomingShows' => $upcomingShows,
            ]
        );
    }
}
