<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Posts;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Logs;

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
    public $selectedEvent = null;
    public $selectedPerformance = null;

    // Edit properties
    public $editingPost = null;
    public $edit_title = '';
    public $edit_content = '';
    public $sortSppStatus = 'preview';
    // Reset page when filter/search changes
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function updatedSelectedEvent()
    {
        $this->resetPage();
    }

    public function updatedSelectedPerformance()
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

    public function editPost($postId)
    {
        $this->editingPost = Posts::find($postId);
        $this->edit_title = $this->editingPost->title;
        $this->edit_content = $this->editingPost->content;
    }

    public function updatePost()
    {
        $this->validate([
            'edit_title' => 'required|min:3',
            'edit_content' => 'required|min:10',
        ]);

        try {
            $this->editingPost->update([
                'title' => $this->edit_title,
                'content' => $this->edit_content,
            ]);

            // Store the ID before resetting
            $postId = $this->editingPost->post_id;

            // Log the update action
            Logs::create([
                'action' => 'Updated a post',
                'navigation' => 'posts',
                'user_id' => Auth::user()->user_id,
                'post_id' => $postId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Reset the properties
            $this->reset(['edit_title', 'edit_content', 'editingPost']);
            
            // Close the modal using the stored ID
            $this->modal('edit-post-' . $postId)->close();
            
            $this->dispatch('post-updated');
            session()->flash('message', 'Post updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating post:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to update post. Please try again.');
        }
    }

    public function deletePost($id)
    {
        try {
            $post = Posts::find($id);
            
            if ($post) {
                // Soft delete the post
                $post->delete();

                // Log the delete action
                Logs::create([
                    'action' => 'Deleted a post',
                    'navigation' => 'posts',
                    'user_id' => Auth::user()->user_id,
                    'post_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                // Delete associated media
                $media = \App\Models\Media::where('post_id', $id)->get();
                foreach ($media as $item) {
                    Storage::disk('public')->delete($item->file_path);
                    $item->delete();
                }
                
                $this->dispatch('post-deleted');
                $this->modal('delete-post-' . $id)->close();
                session()->flash('message', 'Post deleted successfully!');
            }
        } catch (\Exception $e) {
            Log::error('Error deleting post:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to delete post. Please try again.');
        }
    }

    public function cancelEdit()
    {
        $this->reset(['edit_title', 'edit_content', 'editingPost']);
    }

    public function deleteMedia($mediaId)
    {
        try {
            Log::debug('Attempting to delete media', ['mediaId' => $mediaId]);
            
            if (empty($mediaId)) {
                throw new \Exception("Media ID is empty");
            }
            
            $media = \App\Models\Media::where('media_id', $mediaId)->first();
            
            if (!$media) {
                throw new \Exception("Media not found with ID: {$mediaId}");
            }
            
            Log::debug('Found media to delete', ['media' => $media->toArray()]);
            
            // Store post_id before deletion
            $postId = $media->post_id;
            
            // Soft delete the media record
            $media->delete();
            
            // Get the post's remaining media count
            $remainingMedia = \App\Models\Media::where('post_id', $postId)
                ->whereNull('deleted_at')
                ->count();
            
            Log::debug('Media deleted successfully', [
                'mediaId' => $mediaId,
                'remainingCount' => $remainingMedia
            ]);

            // Close the modal
            $this->modal('delete-media-confirmation')->close();
            
            // Dispatch the media-deleted event with the media ID
            $this->dispatch('media-deleted', [
                'mediaId' => $mediaId
            ]);

            // Log the action
            Logs::create([
                'action' => 'Deleted a media',
                'navigation' => 'posts',
                'user_id' => Auth::user()->user_id,
                'post_id' => $postId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Force refresh the component to update the media arrays
            $this->dispatch('$refresh');
            
            session()->flash('message', 'Media deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting media:', [
                'error' => $e->getMessage(),
                'mediaId' => $mediaId,
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Failed to delete media. Please try again.');
        }
    }

    public function getPostsProperty()
    {
        return Posts::with(['media' => function($query) {
                $query->whereNull('deleted_at');
            }, 'events', 'performances'])
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
            ->when($this->selectedEvent, function ($query) {
                $query->where('event_id', $this->selectedEvent);
            })
            ->when($this->selectedPerformance, function ($query) {
                $query->where('performance_id', $this->selectedPerformance);
            })
            ->when($this->sortSppStatus, function ($query) {
                $query->where('spp_status', $this->sortSppStatus);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function modal_close($name){
        $this->modal($name)->close();
    }

    public function publish_post($id){
        try {
             $post = Posts::find($id);
             $post->spp_status = 'publish';
             $post->save();

             Logs::create([
                'action' => 'Published a post',
                'navigation' => 'posts',
                'user_id' => Auth::user()->user_id,
                'post_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
             $this->modal('publish-' . $id)->close();
        } catch (\Exception $e) {
            Log::error('Error updating post:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to update post. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.post-list', [
            'posts' => $this->posts,
            'events' => \App\Models\Events::orderBy('event_name')->get(),
            'performances' => \App\Models\Performances::orderBy('title')->get(),
        ]);
    }
}
