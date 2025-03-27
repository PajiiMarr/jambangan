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

    public function render()
    {
        $posts = Posts::with('media')->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.post-list', [
            'posts' => $posts
        ]);
    }
}
