<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Logs;
use App\Models\User;

class LogsComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $navigationFilter = '';
    public $actionFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $userFilter = '';

    // Delete confirmation
    public $logToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'navigationFilter' => ['except' => ''],
        'actionFilter' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
        'userFilter' => ['except' => ''],
    ];

    public function render()
    {
        $logs = Logs::query()
            ->with('user') // Eager load the user relationship
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhere('action', 'like', '%' . $this->search . '%')
                ->orWhere('navigation', 'like', '%' . $this->search . '%');
            })
            ->when($this->navigationFilter, function ($query) {
                $query->where('navigation', $this->navigationFilter);
            })
            ->when($this->actionFilter, function ($query) {
                $query->where('action', $this->actionFilter);
            })
            ->when($this->userFilter, function ($query) {
                $query->where('user_id', $this->userFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        // Get counts for stats section
        $totalLogs = Logs::count();
        $todayLogs = Logs::whereDate('created_at', now()->toDateString())->count();
        $uniqueUsers = Logs::distinct('user_id')->count('user_id');

        // Get unique navigation types for filter
        $navigationTypes = ['performances', 'posts', 'events', 'manage-site', 'officers', 'bookings', 'users'];
        
        // Get common actions for filter
        $commonActions = Logs::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action')
            ->toArray();
            
        // Get users for filter
        $users = User::orderBy('name')->get();

        return view('livewire.logs-component', [
            'logs' => $logs,
            'totalLogs' => $totalLogs,
            'todayLogs' => $todayLogs,
            'uniqueUsers' => $uniqueUsers,
            'navigationTypes' => $navigationTypes,
            'commonActions' => $commonActions,
            'users' => $users,
        ]);
    }

    public function deleteLog($logId)
    {
        $log = Logs::findOrFail($logId);
        $log->delete();
        session()->flash('message', 'Log entry deleted successfully!');
    }

    public function confirmDelete($logId)
    {
        $this->logToDelete = $logId;
        $this->dispatch('open-flux-modal', name: 'confirm-log-delete');
    }

    public function executeDelete()
    {
        $this->deleteLog($this->logToDelete);
        $this->logToDelete = null;
        $this->dispatch('close-flux-modal', name: 'confirm-log-delete');
    }

    public function closeModal($name)
    {
        $this->dispatch('close-flux-modal', name: $name);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'navigationFilter', 'actionFilter', 'userFilter']);
    }
    
    public function setSort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }
}