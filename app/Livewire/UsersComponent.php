<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserInvitation;

class UsersComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $roleFilter = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;

    // Invitation fields
    public $invite_email = '';
    public $invite_role = 'user';

    // Edit fields
    public $editingUserId = null;
    public $edit_name = '';
    public $edit_email = '';
    public $edit_role = 'user';

    // Delete confirmation
    public $userToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'roleFilter' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 10],
    ];

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('request_status', $this->statusFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $totalUsers = User::count();
        $activeUsers = User::where('request_status', 'accepted')->count();
        $pendingUsers = User::where('request_status', 'pending')->count();

        return view('livewire.users-component', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'pendingUsers' => $pendingUsers,
        ]);
    }

    public function sendInvitation()
    {
        $this->validate([
            'invite_email' => 'required|email|unique:users,email',
            'invite_role' => 'required|in:user,editor,admin',
        ]);

        // // In a real app, you would create an invitation record and send an email
        // Mail::to($this->invite_email)->send(new UserInvitation([
        //     'email' => $this->invite_email,
        //     'role' => $this->invite_role,
        // ]));

        $this->reset(['invite_email', 'invite_role']);
        $this->dispatch('close-flux-modal', name: 'invite-user');
        session()->flash('message', 'Invitation sent successfully!');
    }

    public function acceptUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['request_status' => 'accepted']);
        session()->flash('message', 'User accepted successfully!');
    }

    public function rejectUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['request_status' => 'rejected']);
        session()->flash('message', 'User rejected successfully!');
    }

    public function closeModal($name)
    {
        $this->dispatch('close-flux-modal', name: $name);
    }
}