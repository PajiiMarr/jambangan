@php
    $isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
    // dd($isMobile);
@endphp

<div>
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <p class="text-black dark:text-white mt-1">Manage and organize your performances</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <flux:modal.trigger name="add-performance">
                    <flux:button variant="primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                        Add New Performance
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>
    </div>

    <flux:modal 
        name="add-performance" 
        class="w-full md:w-123"
        :variant="$isMobile ? 'flyout' : null"
        :position="$isMobile ? 'bottom' : null"
    >
        <flux:heading size="lg">Add Performance</flux:heading>
        
        <flux:text class="mb-4">Add a new performance to your collection.</flux:text>
        
        <flux:input class="mb-4" label="Title" wire:model="add_title" placeholder="Enter Title" />
        
        <flux:textarea class="py-4 mb-4" label="Description" wire:model="add_description" placeholder="Enter Description" />
        
        <flux:label>Cover Photo</flux:label>
        <x-inputs.filepond class="mt-5" wire:model="add_performance_file" />  
        <flux:button variant="primary" wire:click="save">Add Performance</flux:button>
    </flux:modal>

    <!-- Filters and Search Section -->
    <div class="bg-white dark:bg-red-900/20 rounded-xl shadow-sm border border-gray-200 dark:border-red-800/30 p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search performances..." 
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30"
                    >
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Sort -->
            <div class="flex gap-3">
                <div class="relative">
                    <select 
                        wire:model.live="sortBy" 
                        class="appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                    >
                        <option value="created_at">Date Added</option>
                        <option value="title">Title</option>
                        <option value="upcoming_date">Upcoming Date</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <div class="relative">
                    <select 
                        wire:model.live="sortDirection" 
                        class="appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                    >
                        <option value="desc">Descending</option>
                        <option value="asc">Ascending</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="flex gap-3">
                <div class="relative">
                    <select 
                        wire:model.live="dateFilter" 
                        class="appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                    >
                        <option value="">All Dates</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="past">Past</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <div class="relative">
                    <select 
                        wire:model.live="perPage" 
                        class="appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                    >
                        <option value="10">10 per page</option>
                        <option value="20">20 per page</option>
                        <option value="50">50 per page</option>
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
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white dark:bg-red-900/20 rounded-xl shadow-sm border border-gray-200 dark:border-red-800/30 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Performances</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalPerformances }}</p>
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
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Upcoming Shows</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $upcomingShows }}</p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="flex h-full w-full flex-1 gap-6 rounded-2xl">
        <!-- Left Panel -->
        <div class="w-full md:w-1/2 overflow-auto max-h-full">
            <div class="grid grid-cols-2 w-full overflow-auto max-h-full">
                @if ($performances->isEmpty())
                    <div class="mt-2 col-span-2 p-8 text-center rounded-xl bg-gray-50">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">No performances available.</p>
                        <p class="text-gray-400 text-sm mt-2">Add your first performance to get started.</p>
                    </div>
                @else
                    @foreach ($performances as $performance)
                    <!-- Performance Card -->
                        <div 
                        wire:key="performance-{{ $performance->performance_id }}"
                        wire:click="showPerformance({{ $performance->performance_id }})"
                    class="col-span-2 md:col-span-2 m-2 rounded-xl shadow-sm hover:shadow-md bg-white relative overflow-hidden h-60 group cursor-pointer transition-all duration-300 border border-gray-100"
                        >
                        @if ($performance->media)
                            <div class="absolute inset-0 w-full h-full transition-transform duration-500 ease-in-out group-hover:scale-105">
                                <img 
                                    src="{{ $performance->media->file_url }}" 
                                    alt="{{ $performance->title }}" 
                                    class="w-full h-full object-cover" 
                                />
                            </div>
                        @endif

                        <!-- Gradient overlay -->
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/80 via-black/50 to-transparent p-4 z-10">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-white/80 text-xs">
                                    {{ $performance->created_at->format('M d, Y') }}
                                </span>
                            </div>
                            <h2 class="text-lg font-semibold text-white truncate">{{ $performance->title }}</h2>
                            <p class="text-white/80 text-sm mt-1 truncate">{{ Str::limit($performance->description, 50) }}</p>
                        </div>

                        @unless($performance->media)
                            <div class="absolute inset-0 bg-gray-50 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endunless

                        <!-- Action buttons - Add stop propagation to prevent showing performance when clicking buttons -->
                        <div class="absolute top-2 right-2 flex gap-2 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity">
                            <flux:modal.trigger 
                                name="edit-performance-{{ $performance->performance_id }}"
                                wire:click="openEditModal({{ $performance->performance_id }})"
                                wire:key="edit-trigger-{{ $performance->performance_id }}"
                            >
                                <flux:button 
                                    variant="outline" 
                                    class="p-2 bg-white/90 rounded-full md:hover:bg-white transition-colors" 
                                    title="Edit Performance"
                                >
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </flux:button>
                            </flux:modal.trigger>
                            <flux:modal.trigger name="delete-performance-{{ $performance->performance_id }}">
                                <flux:button 
                                    variant="outline" 
                                    class="p-2 bg-white/90 rounded-full md:hover:bg-white transition-colors" 
                                    title="Delete Performance"
                                >
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </flux:button>
                            </flux:modal.trigger>
                        </div>
                        </div>

                        <!-- Move modals outside the performance card element -->
                        <!-- Edit Modal -->
                        <flux:modal 
                            name="edit-performance-{{ $performance->performance_id }}" 
                            class="md:w-123"
                            :variant="$isMobile ? 'flyout' : null"
                            :position="$isMobile ? 'bottom' : null"
                            wire:ignore.self
                        >
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Edit Performance</flux:heading>
                                <flux:text class="mt-2">Update performance details and media.</flux:text>
                            </div>
                            
                            @if($performance->media)
                                <div class="rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                                    <img 
                                        src="{{ $performance->media->file_url }}" 
                                        alt="{{ $performance->title }}" 
                                        class="w-full h-48 object-cover"
                                    >
                                </div>
                            @endif

                            <div class="space-y-4">
                                <div>
                                    <flux:input 
                                        label="Title" 
                                        wire:model="edit_title" 
                                        placeholder="Performance title"
                                    />
                                    @error('edit_title') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <div>
                                    <flux:textarea 
                                        label="Description" 
                                        wire:model="edit_description" 
                                        placeholder="Performance description"
                                        rows="4"
                                    />
                                    @error('edit_description') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Performance Image</label>
                                    <x-inputs.filepond wire:model="edit_performance_file" />
                                    @error('edit_performance_file') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <div class="flex justify-end gap-4 pt-4">
                                    <flux:button 
                                        variant="outline"
                                        wire:click="closeModal('edit-performance-{{ $performance->performance_id }}')"
                                    >
                                        Cancel
                                    </flux:button>
                                    <flux:button 
                                        wire:click="updatePerformance" 
                                        variant="primary"
                                    >
                                        Save Changes
                                    </flux:button>
                                </div>
                            </div>
                        </div>
                        </flux:modal>

                        <!-- Delete Confirmation Modal -->
                        <flux:modal 
                        name="delete-performance-{{ $performance->performance_id }}" 
                        class="md:w-96"
                        :variant="$isMobile ? 'flyout' : null"
                        :position="$isMobile ? 'bottom' : null"
                        >
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Delete Performance</flux:heading>
                                <flux:text class="mt-2">Are you sure you want to delete this performance? This action cannot be undone.</flux:text>
                            </div>
                            <div class="flex justify-end gap-4">
                                <flux:button 
                                    variant="outline"
                                    wire:click="closeModal('delete-performance-{{ $performance->performance_id }}')"
                                >
                                    Cancel
                                </flux:button>
                                <flux:button 
                                    variant="danger"
                                    wire:click="deletePerformance({{ $performance->performance_id }})"
                                >
                                    Delete Performance
                                </flux:button>
                            </div>
                        </div>
                        </flux:modal>
                    @endforeach
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $performances->links() }}
            </div>
        </div>

        <!-- Right Panel -->
        <div class="hidden md:block w-1/2 p-6 rounded-2xl bg-white dark:bg-red-900/20 shadow-sm border border-gray-200 dark:border-red-800/30">
            @if ($selectedPerformance)
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100">{{ $selectedPerformance->title }}</h2>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                            Added {{ $selectedPerformance->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <flux:modal.trigger name="edit-performance-{{ $selectedPerformance->performance_id }}">
                        <flux:button variant="outline" size="sm" class="border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </flux:button>
                    </flux:modal.trigger>
                    <flux:modal.trigger name="delete-performance-{{ $selectedPerformance->performance_id }}">
                        <flux:button variant="danger" size="sm" class="bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-900/70">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
        
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-5">
                    <p class="text-gray-600 dark:text-gray-300">{{ $selectedPerformance->description }}</p>
                </div>
        
                @if ($selectedPerformance->media)
                    <div class="mt-6 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <img 
                            src="{{ $selectedPerformance->media->file_url }}" 
                            alt="{{ $selectedPerformance->title }}" 
                            class="w-full max-h-80 object-cover"
                        />
                    </div>
                @endif
            </div>
            @else
                <div class="rounded-xl bg-gray-50 dark:bg-gray-800/50 p-8 flex flex-col items-center justify-center mt-4">
                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                    </svg>
                    <p class="text-gray-600 dark:text-gray-300 font-medium">Select a performance to view details</p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Click on any performance from the list to see more information</p>
                </div>
            @endif
        </div>


        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif
    </div>
    @script
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Handle modal closing
            window.addEventListener('close-flux-modal', (event) => {
                const modalName = event.detail.name;
                const modal = document.querySelector(`[data-modal-name="${modalName}"]`);
                if (modal) {
                    modal.dispatchEvent(new CustomEvent('close'));
                }
            });
        });
    </script>
    @endscript
</div>