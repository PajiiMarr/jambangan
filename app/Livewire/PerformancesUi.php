<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Performances;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class PerformancesUi extends Component
{

    use WithPagination;
    public $title;
    public $description;
    public $perPage = 10;
    public $selectedPerformance;


    public function mount() {
        $this->title = '';
        $this->description = '';
    }

    #[On('performance-added')]
    public function handlePerformanceAdded($performance = null)
    {
        // This will make sure the list is refreshed on the next render
        $this->resetPage(); // If you're using pagination
        
        // Optionally set the newly added performance as selected
        if ($performance) {
            $this->showPerformance($performance['performance_id']);
        }
    }

    public function showPerformance($id = null)
    {
        Log::debug('showPerformance called with ID:', ['id' => $id]);
        if (!$id) return;
        
        $this->selectedPerformance = Performances::with('media')->find($id);
        Log::debug('Selected Performance:', ['performance' => $this->selectedPerformance]);
    }


    public function render()
    {

        $performances = Performances::with('media')->orderBy('created_at', 'desc')->paginate($this->perPage);

        if (!$this->selectedPerformance && $performances->isNotEmpty()) {
            $this->selectedPerformance = $performances->first();
        }

        return view('livewire.performances-ui',
            [
                'performances' => $performances,
                'selectedPerformance' => $this->selectedPerformance,
            ]
        );
    }
}
