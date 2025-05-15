<!-- Root element -->
<div>
    <div class="w-full space-y-4" > 
        <!-- Header with sorting/filtering controls -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-4 bg-white dark:bg-zinc-800 rounded-xl shadow-sm">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Posts</h2>
                <p class="text-sm text-gray-500 dark:text-zinc-400">{{ $posts->total() }} total posts</p>
            </div>
        </div>

        <!-- Filters and Search Section -->
        <div class="bg-white dark:bg-red-900/20 rounded-xl shadow-sm border border-gray-200 dark:border-red-800/30 p-4 mb-6 w-full">
            <div class="flex flex-col md:flex-row gap-4 w-full">
                <!-- Search -->
                <div class="w-full md:w-1/3">
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search posts..." 
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30"
                        >
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Sort -->
                <div class="flex gap-3 w-full md:w-auto">
                    <div class="relative w-full md:w-40">
                        <select 
                            wire:model.live="sortBy" 
                            class="w-full appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                        >
                            <option value="created_at">Date Added</option>
                            <option value="title">Title</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="relative w-full md:w-40">
                        <select 
                            wire:model.live="sortDirection" 
                            class="w-full appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                        >
                            <option value="desc">Latest</option>
                            <option value="asc">Earliest</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <select 
                        wire:model.live="sortSppStatus" 
                        class="appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                    >
                        <option value="preview">Preview</option>
                        <option value="publish">Publish</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Filter -->
                <div class="flex gap-3 w-full md:w-auto">
                    <div class="relative w-full md:w-40">
                        <select 
                            wire:model.live="filter" 
                            class="w-full appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                        >
                            <option value="all">All Posts</option>
                            <option value="with_media">With Media</option>
                            <option value="text_only">Text Only</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="relative w-full md:w-48">
                        <select 
                            wire:model.live="selectedEvent" 
                            class="w-full appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                        >
                            <option value="">All Events</option>
                            @foreach($events as $event)
                                <option value="{{ $event->event_id }}">{{ $event->event_name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="relative w-full md:w-48">
                        <select 
                            wire:model.live="selectedPerformance" 
                            class="w-full appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                        >
                            <option value="">All Performances</option>
                            @foreach($performances as $performance)
                                <option value="{{ $performance->performance_id }}">{{ $performance->title }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white dark:bg-red-900/20 rounded-xl shadow-sm border border-gray-200 dark:border-red-800/30 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Posts</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $posts->total() }}</p>
                    </div>
                    <div class="p-3 bg-gray-100 dark:bg-red-900/30 rounded-lg">
                        <svg class="w-6 h-6 text-gray-500 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-red-900/20 rounded-xl shadow-sm border border-gray-200 dark:border-red-800/30 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Posts with Media</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $posts->filter(fn($post) => $post->media->isNotEmpty())->count() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <svg class="w-6 h-6 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-red-900/20 rounded-xl shadow-sm border border-gray-200 dark:border-red-800/30 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Text Only Posts</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $posts->filter(fn($post) => $post->media->isEmpty())->count() }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                        <svg class="w-6 h-6 text-purple-500 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Posts list -->
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 gap-4">
                @forelse ($posts as $post)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm overflow-hidden transition-all duration-200 hover:shadow-md">
                        <!-- Post header -->
                        <div class="px-6 py-3 border-b border-gray-200 dark:border-zinc-700 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $post->user->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-zinc-400">
                                        {{ $post->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    {{ $post->media->isEmpty() ? 'bg-gray-100 text-gray-800 dark:bg-zinc-700 dark:text-gray-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200' }}">
                                    {{ $post->media->isEmpty() ? 'Text' : 'Media' }}
                                </span>
                                <div class="flex items-center space-x-2">
                                    <flux:modal.trigger name="edit-post-{{ $post->post_id }}">
                                        <flux:button variant="ghost" @click="$wire.editPost({{ $post->post_id }})">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </flux:button>
                                    </flux:modal.trigger>

                                    <flux:modal.trigger name="delete-post-{{ $post->post_id }}">
                                        <flux:button variant="ghost" class="text-red-500 hover:text-red-600">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </flux:button>
                                    </flux:modal.trigger>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Post content -->
                        <div class="px-6 py-4">
                            <flux:modal.trigger name="view-post-{{ $post->post_id }}">
                                <flux:button variant="ghost" class="text-left">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 hover:text-accent dark:hover:text-accent transition-colors duration-200">{{ $post->title }}</h3>
                                </flux:button>
                            </flux:modal.trigger>
                            <p class="text-base text-gray-700 dark:text-zinc-300 line-clamp-3">{{ $post->content }}</p>
                        </div>
                        
                        <!-- Media gallery -->
                        @if($post->media->isNotEmpty())
                            <div class="px-6 pb-4" data-post-id="{{ $post->post_id }}">
                                <div class="grid grid-cols-3 gap-4">
                                    @foreach ($post->media->take(3) as $media)
                                        <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-zinc-700 relative group">
                                            @if ($media->type === 'image')
                                                <img 
                                                    src="{{ $media->file_url }}" 
                                                    alt="Post image" 
                                                    data-media-id="{{ $media->media_id }}"
                                                    class="w-full h-40 object-cover cursor-pointer hover:opacity-90 transition-opacity"
                                                    @click="$dispatch('open-gallery', { 
                                                        postId: '{{ $post->post_id }}',
                                                        initialIndex: {{ $loop->index }},
                                                        mediaUrls: {{ json_encode($post->media->pluck('file_url')) }},
                                                        mediaIds: {{ json_encode($post->media->pluck('media_id')) }},
                                                        mediaTypes: {{ json_encode($post->media->pluck('type')) }},
                                                        thumbnailUrls: {{ json_encode($post->media->map(function($m) { 
                                                            return $m->type === 'video' ? ($m->thumbnail_url ?? asset('images/video-thumbnail.jpg')) : $m->file_url; 
                                                        })) }}
                                                    })">
                                            @elseif ($media->type === 'video')
                                                <div 
                                                    class="w-full h-40 relative cursor-pointer hover:opacity-90 transition-opacity"
                                                    @click="$dispatch('open-gallery', { 
                                                        postId: '{{ $post->post_id }}',
                                                        initialIndex: {{ $loop->index }},
                                                        mediaUrls: {{ json_encode($post->media->pluck('file_url')) }},
                                                        mediaIds: {{ json_encode($post->media->pluck('media_id')) }},
                                                        mediaTypes: {{ json_encode($post->media->pluck('type')) }},
                                                        thumbnailUrls: {{ json_encode($post->media->map(function($m) { 
                                                            return $m->type === 'video' ? ($m->thumbnail_url ?? asset('images/video-thumbnail.jpg')) : $m->file_url; 
                                                        })) }}
                                                    })">
                                                    <img 
                                                        src="{{ $media->thumbnail_url ?? asset('images/video-thumbnail.jpg') }}" 
                                                        alt="Video thumbnail" 
                                                        class="w-full h-full object-cover"
                                                    >
                                                    <div class="absolute inset-0 flex items-center justify-center">
                                                        <div class="w-12 h-12 bg-black/50 rounded-full flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M8 5v14l11-7z"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($post->media->count() > 3)
                                        <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-zinc-700 bg-gray-100 dark:bg-zinc-700 flex items-center justify-center cursor-pointer"
                                             @click="$dispatch('open-gallery', { 
                                                 postId: '{{ $post->post_id }}',
                                                 initialIndex: 0,
                                                 mediaUrls: {{ json_encode($post->media->pluck('file_url')) }},
                                                 mediaIds: {{ json_encode($post->media->pluck('media_id')) }},
                                                 mediaTypes: {{ json_encode($post->media->pluck('type')) }},
                                                 thumbnailUrls: {{ json_encode($post->media->map(function($m) { 
                                                     return $m->type === 'video' ? ($m->thumbnail_url ?? asset('images/video-thumbnail.jpg')) : $m->file_url; 
                                                 })) }}
                                             })">
                                            <span class="text-sm text-gray-600 dark:text-gray-300">+{{ $post->media->count() - 3 }} more</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Edit Post Modal -->
                        <flux:modal 
                            name="edit-post-{{ $post->post_id }}" 
                            class="md:w-123"
                            variant="dialog"
                            data-modal-name="edit-post-{{ $post->post_id }}">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Edit Post</flux:heading>
                                    <flux:text class="mt-2">Update your post details.</flux:text>
                                </div>

                                <form wire:submit="updatePost">
                                    <div class="space-y-4">
                                        <flux:input 
                                            label="Title" 
                                            wire:model="edit_title" 
                                            placeholder="Enter post title" 
                                        />
                                        @error('edit_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                                        <flux:input 
                                            label="Content" 
                                            wire:model="edit_content" 
                                            type="textarea" 
                                            rows="4"
                                            placeholder="Enter post content" 
                                        />
                                        @error('edit_content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="flex mt-6">
                                        <flux:spacer />
                                        <flux:button type="submit" variant="primary">Save Changes</flux:button>
                                    </div>
                                </form>
                            </div>
                        </flux:modal>

                        <!-- Delete Post Modal -->
                        <flux:modal 
                            name="delete-post-{{ $post->post_id }}" 
                            class="max-w-md"
                            variant="dialog"
                            data-modal-name="delete-post-{{ $post->post_id }}">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Delete Post</flux:heading>
                                    <flux:text class="mt-2">Are you sure you want to delete this post? This action cannot be undone.</flux:text>
                                </div>

                                <div class="flex">
                                    <flux:spacer />
                                    <flux:button 
                                        wire:click="deletePost({{ $post->post_id }})" 
                                        variant="danger"
                                    >
                                        Delete Post
                                    </flux:button>
                                </div>
                            </div>
                        </flux:modal>

                        <!-- View Post Modal -->
                        <flux:modal 
                            name="view-post-{{ $post->post_id }}" 
                            class="max-w-4xl"
                            variant="dialog"
                            data-modal-name="view-post-{{ $post->post_id }}">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">{{ $post->title }}</flux:heading>
                                    <flux:text class="mt-2">{{ $post->content }}</flux:text>
                                </div>

                                @if($post->media->isNotEmpty())
                                    <div>
                                        <flux:heading size="lg">Media</flux:heading>
                                        <div class="grid grid-cols-3 gap-4 mt-4">
                                            @foreach($post->media as $media)
                                                <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                                    @if($media->type === 'image')
                                                        <img src="{{ $media->file_url }}" alt="Post image" class="w-full h-40 object-cover">
                                                    @elseif($media->type === 'video')
                                                        <video class="w-full h-40 object-cover" controls>
                                                            <source src="{{ $media->file_url }}" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </flux:modal>
                    </div>
                @empty
                    <div class="rounded-xl bg-white dark:bg-zinc-800 p-8 flex flex-col items-center justify-center shadow-sm">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">No posts found</h3>
                        <p class="text-gray-500 dark:text-zinc-400 text-center max-w-md">
                            @if($search)
                                No posts match your search criteria. Try different keywords.
                            @else
                                Create your first post to get started!
                            @endif
                        </p>
                        @if(!$search)
                            <button class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-accent hover:bg-accent/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                                Create Post
                            </button>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="mt-6">
                    {{ $posts->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Gallery Modal -->
    <div x-data="{ 
        open: false,
        postId: null,
        currentIndex: 0,
        media: [],
        init() {
            this.$wire.on('media-deleted', ({ mediaId }) => {
                // Find the index of the deleted media
                const deletedIndex = this.media.findIndex(item => item.media_id === mediaId);
                
                // Remove the deleted media from the array
                this.media = this.media.filter(item => item.media_id !== mediaId);
                
                if (this.media.length === 0) {
                    // If no media left, close the gallery
                    this.open = false;
                } else {
                    // If we deleted the current image, show the next one
                    if (deletedIndex === this.currentIndex) {
                        // If we're at the end, go to the previous image
                        if (this.currentIndex >= this.media.length) {
                            this.currentIndex = this.media.length - 1;
                        }
                    } else if (deletedIndex < this.currentIndex) {
                        // If we deleted an image before the current one, adjust the index
                        this.currentIndex--;
                    }
                }
            });
        }
    }" 
        x-show="open" 
        class="fixed inset-0 z-50 overflow-y-auto" 
        style="display: none;"
        @open-gallery.window="
            open = true;
            postId = $event.detail.postId;
            currentIndex = $event.detail.initialIndex;
            media = $event.detail.mediaUrls.map((url, index) => ({ 
                src: url, 
                type: $event.detail.mediaTypes[index],
                media_id: $event.detail.mediaIds[index],
                thumbnail: $event.detail.thumbnailUrls[index]
            }));
        "
        @keydown.escape.window="open = false">
        <!-- Background overlay -->
        <div x-show="open" 
            x-transition:enter="ease-out duration-300" 
            x-transition:enter-start="opacity-0" 
            x-transition:enter-end="opacity-100" 
            x-transition:leave="ease-in duration-200" 
            x-transition:leave-start="opacity-100" 
            x-transition:leave-end="opacity-0" 
            class="fixed inset-0 bg-black transition-opacity" 
            aria-hidden="true"
            @click="open = false"></div>

        <!-- Modal panel -->
        <div x-show="open" 
            x-transition:enter="ease-out duration-300" 
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
            x-transition:leave="ease-in duration-200" 
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
            class="fixed inset-0 overflow-hidden"
            @click.stop>
            
            <!-- Main content -->
            <div class="absolute inset-0 flex flex-col">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-2 bg-black/50 text-white">
                    <div class="text-sm">
                        <span x-text="currentIndex + 1"></span> / <span x-text="media.length"></span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <flux:modal.trigger name="delete-media-confirmation">
                            <flux:button 
                                x-show="media[currentIndex]"
                                variant="ghost"
                                class="text-white hover:text-red-400"
                                title="Delete media"
                                @click="$dispatch('set-delete-media-id', { mediaId: media[currentIndex].media_id })">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </flux:button>
                        </flux:modal.trigger>
                        <button @click="open = false" class="text-white hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Media container -->
                <div class="flex-1 relative">
                    <template x-for="(item, index) in media" :key="index">
                        <div x-show="currentIndex === index"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="absolute inset-0 flex items-center justify-center">
                            <template x-if="item.type === 'image'">
                                <img :src="item.src" class="max-h-full max-w-full object-contain" :alt="'Image ' + (index + 1)">
                            </template>
                            <template x-if="item.type === 'video'">
                                <video 
                                    class="max-h-full max-w-full" 
                                    controls
                                    :poster="item.thumbnail || '/images/video-thumbnail.jpg'">
                                    <source :src="item.src" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </template>
                        </div>
                    </template>

                    <!-- Navigation arrows -->
                    <template x-if="media.length > 1">
                        <div>
                            <button 
                                @click="currentIndex = (currentIndex - 1 + media.length) % media.length"
                                class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-3 rounded-full hover:bg-black/70 transition-colors"
                                x-show="media.length > 1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button 
                                @click="currentIndex = (currentIndex + 1) % media.length"
                                class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-3 rounded-full hover:bg-black/70 transition-colors"
                                x-show="media.length > 1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>

                <!-- Thumbnail strip -->
                <div class="bg-black/50 p-2" x-show="media.length > 1">
                    <div class="flex space-x-2 overflow-x-auto pb-2">
                        <template x-for="(item, index) in media" :key="index">
                            <button 
                                @click="currentIndex = index"
                                class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 transition-all"
                                :class="currentIndex === index ? 'border-white' : 'border-transparent hover:border-gray-400'">
                                <template x-if="item.type === 'image'">
                                    <img :src="item.src" class="w-full h-full object-cover" :alt="'Thumbnail ' + (index + 1)">
                                </template>
                                <template x-if="item.type === 'video'">
                                    <div class="relative w-full h-full">
                                        <img :src="item.thumbnail || '/images/video-thumbnail.jpg'" class="w-full h-full object-cover" :alt="'Video thumbnail ' + (index + 1)">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-6 h-6 bg-black/50 rounded-full flex items-center justify-center">
                                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Media Confirmation Modal -->
    <flux:modal name="delete-media-confirmation" class="max-w-md">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Media</flux:heading>
                <flux:text class="mt-2">Are you sure you want to delete this media? This action cannot be undone.</flux:text>
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button 
                    variant="danger"
                    x-data
                    @click="
                        $wire.deleteMedia($store.deleteMediaId);
                        $dispatch('close-modal', 'delete-media-confirmation');
                    ">
                    Delete Media
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <!-- Add the store for media ID -->
    <div x-data
        x-init="$store.deleteMediaId = null"
        x-on:set-delete-media-id.window="$store.deleteMediaId = $event.detail.mediaId">
    </div>
</div>
