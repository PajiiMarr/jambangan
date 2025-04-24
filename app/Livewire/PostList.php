<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Posts;

class PostList extends Component
{
    use WithPagination;

    protected $listeners = ['postUploaded' => '$refresh'];

    public $perPage = 10;

    // Sorting
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Searching and Filtering
    public $search = '';
    public $filter = 'all';

    // Reset page when filter/search changes
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortBy = $field;
    }

    public function filterBy($type)
    {
        $this->filter = $type;
    }

    public function getPostsProperty()
    {
        return Posts::with('media')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filter === 'with_media', function ($query) {
                $query->has('media');
            })
            ->when($this->filter === 'text_only', function ($query) {
                $query->doesntHave('media');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.post-list', [
            'posts' => $this->posts,
        ]);
    }
}
