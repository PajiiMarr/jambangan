<div class="w-full space-y-4">
    <!-- Header with sorting/filtering controls -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-4 bg-white dark:bg-zinc-800 rounded-xl shadow-sm">
        <div>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Posts</h2>
            <p class="text-sm text-gray-500 dark:text-zinc-400">{{ $posts->total() }} total posts</p>
        </div>
    
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <!-- Search -->
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    class="pl-10 w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 text-sm focus:ring-accent focus:border-accent"
                    placeholder="Search posts...">
            </div>
    
            <!-- Sort dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open"
                    class="inline-flex justify-between items-center w-full sm:w-48 px-4 py-2 text-sm font-medium text-gray-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-accent">
                    <span>Sort: {{ ucfirst($sortBy) }} ({{ $sortDirection === 'asc' ? '↑' : '↓' }})</span>
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
    
                <div 
                    x-show="open"
                    @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-zinc-800 ring-1 ring-black ring-opacity-5 z-10">
                    <div class="py-1">
                        <button 
                            wire:click="sortBy('created_at')"
                            class="block px-4 py-2 text-sm w-full text-left hover:bg-gray-100 dark:hover:bg-zinc-700">
                            Date {{ $sortBy === 'created_at' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
                        </button>
                        <button 
                            wire:click="sortBy('title')"
                            class="block px-4 py-2 text-sm w-full text-left hover:bg-gray-100 dark:hover:bg-zinc-700">
                            Title {{ $sortBy === 'title' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
                        </button>
                    </div>
                </div>
            </div>
    
            <!-- Filter dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open"
                    class="inline-flex justify-between items-center w-full sm:w-40 px-4 py-2 text-sm font-medium text-gray-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-accent">
                    <span>Filter</span>
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                </button>
    
                <div 
                    x-show="open"
                    @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-zinc-800 ring-1 ring-black ring-opacity-5 z-10">
                    <div class="py-1">
                        <button 
                            wire:click="filterBy('all')"
                            class="block px-4 py-2 text-sm w-full text-left hover:bg-gray-100 dark:hover:bg-zinc-700">
                            All Posts
                        </button>
                        <button 
                            wire:click="filterBy('with_media')"
                            class="block px-4 py-2 text-sm w-full text-left hover:bg-gray-100 dark:hover:bg-zinc-700">
                            With Media
                        </button>
                        <button 
                            wire:click="filterBy('text_only')"
                            class="block px-4 py-2 text-sm w-full text-left hover:bg-gray-100 dark:hover:bg-zinc-700">
                            Text Only
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
        @forelse ($posts as $post)
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm overflow-hidden transition-all duration-200 hover:shadow-md">
                <!-- Post header -->
                <div class="p-4 border-b border-gray-200 dark:border-zinc-700 flex items-center justify-between">
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
                    <div class="flex items-center space-x-2">
                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                            {{ $post->media->isEmpty() ? 'bg-gray-100 text-gray-800 dark:bg-zinc-700 dark:text-gray-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200' }}">
                            {{ $post->media->isEmpty() ? 'Text' : 'Media' }}
                        </span>
                        <button class="text-gray-400 hover:text-gray-500 dark:hover:text-zinc-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Post content -->
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $post->title }}</h3>
                    <p class="text-gray-700 dark:text-zinc-300 whitespace-pre-line">{{ $post->content }}</p>
                </div>
                
                <!-- Media gallery -->
                @if($post->media->isNotEmpty())
                    <div class="px-4 pb-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($post->media as $media)
                                <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-zinc-700">
                                    @if ($media->type === 'image')
                                        <img 
                                            src="{{ $media->file_url }}" 
                                            alt="Post image" 
                                            class="w-full h-auto object-cover cursor-pointer hover:opacity-90 transition-opacity"
                                            @click="$dispatch('img-preview', { src: '{{ $media->file_url }}' })">
                                    @elseif ($media->type === 'video')
                                        <video 
                                            class="w-full" 
                                            controls
                                            poster="{{ $media->thumbnail_url ?? asset('images/video-thumbnail.jpg') }}">
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
    <!-- Posts list -->

    <!-- Pagination -->
    @if($posts->hasPages())
        <div class="mt-6 px-4">
            {{ $posts->onEachSide(1)->links() }}
        </div>
    @endif


<!-- Image preview modal -->
<div x-data="{ open: false, src: '' }" 
x-on:img-preview.window="open = true; src = $event.detail.src"
x-show="open"
class="fixed inset-0 z-50 overflow-y-auto" 
aria-labelledby="modal-title" 
role="dialog" 
aria-modal="true">
<div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
   <div x-show="open" 
        x-transition:enter="ease-out duration-300" 
        x-transition:enter-start="opacity-0" 
        x-transition:enter-end="opacity-100" 
        x-transition:leave="ease-in duration-200" 
        x-transition:leave-start="opacity-100" 
        x-transition:leave-end="opacity-0" 
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
        aria-hidden="true"
        @click="open = false"></div>
   
   <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
   
   <div x-show="open" 
        x-transition:enter="ease-out duration-300" 
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
        x-transition:leave="ease-in duration-200" 
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
        class="inline-block align-bottom bg-white dark:bg-zinc-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
       <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
           <img :src="src" alt="Preview" class="w-full h-auto max-h-[80vh] object-contain">
       </div>
       <div class="bg-gray-50 dark:bg-zinc-800/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
           <button type="button" 
                   @click="open = false" 
                   class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-zinc-700 shadow-sm px-4 py-2 bg-white dark:bg-zinc-800 text-base font-medium text-gray-700 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
               Close
           </button>
       </div>
   </div>
</div>
</div>
</div>
