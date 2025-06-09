@php
$isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
@endphp

<div>
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Activity Logs</h1>
                <p class="text-black dark:text-white mt-1">Monitor and track system activities</p>
            </div>
        </div>
    </div>

    <!-- Filters and Search Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="w-full md:w-[20%] flex-1">
                <div class="w-full relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search logs..." 
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    >
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Navigation Filter -->
            <div class="w-full md:w-[20%] flex gap-3">
                <div class="w-full relative">
                    <select 
                        wire:model.live="navigationFilter" 
                        class="w-full appearance-none rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200"
                    >
                        <option value="">All Sections</option>
                        @foreach($navigationTypes as $navType)
                            <option value="{{ $navType }}">{{ ucfirst($navType) }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Action Filter -->
            <div class="w-full md:w-[20%] flex gap-3">
                <div class="w-full relative">
                    <select 
                        wire:model.live="actionFilter" 
                        class="w-full appearance-none rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200"
                    >
                        <option value="">All Actions</option>
                        @foreach($commonActions as $action)
                            <option value="{{ $action }}">{{ ucfirst($action) }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- User Filter -->
            <div class="w-full md:w-[20%] flex gap-3">
                <div class="w-full relative">
                    <select 
                        wire:model.live="userFilter" 
                        class="w-full appearance-none rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200"
                    >
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Sort and Per Page -->
            <div class="w-full md:w-[20%] flex gap-3">
                <div class="w-1/2 relative">
                    <select 
                        wire:model.live="sortBy" 
                        class="w-full appearance-none rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200"
                    >
                        <option value="created_at">Date</option>
                        <option value="navigation">Section</option>
                        <option value="action">Action</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <div class="w-1/2 relative">
                    <select 
                        wire:model.live="perPage" 
                        class="w-full appearance-none rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200"
                    >
                        <option value="10">10 per page</option>
                        <option value="20">20 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
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
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Log Entries</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalLogs }}</p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Today's Activities</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $todayLogs }}</p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-green-500 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $uniqueUsers }}</p>
                </div>
                <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-purple-500 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        @if ($logs->isEmpty())
            <div class="p-8 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 font-medium">No logs found</p>
                <p class="text-gray-400 text-sm mt-2">Try adjusting your search or filter criteria</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Section</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Timestamp</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($logs as $log)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $log->user ? $log->user->name : 'System' }}
                                            </div>
                                            @if($log->user)
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $log->user->email }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ ucfirst($log->navigation) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ in_array($log->action, ['create', 'add', 'insert']) ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                        {{ in_array($log->action, ['update', 'edit', 'modify']) ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : '' }}
                                        {{ in_array($log->action, ['delete', 'remove']) ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}
                                        {{ in_array($log->action, ['view', 'read', 'access']) ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : '' }}">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <div>{{ $log->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs">{{ $log->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <!-- View Log Details Modal Trigger -->
                                        <flux:modal.trigger name="view-log-{{ $log->id }}">
                                            <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </flux:modal.trigger>

                                        <flux:modal 
                                            name="view-log-{{ $log->id }}" 
                                            class="md:w-123"
                                            :variant="$isMobile ? 'flyout' : null"
                                            :position="$isMobile ? 'bottom' : null"
                                        >
                                            <div class="space-y-6">
                                                <div>
                                                    <flux:heading class="text-start" size="lg">Log Details</flux:heading>
                                                    <flux:text class="mt-2 text-start">Viewing detailed information for this log entry.</flux:text>
                                                </div>

                                                <div class="space-y-4">
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">User</p>
                                                            <p class="mt-1">{{ $log->user ? $log->user->name : 'System' }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                                                            <p class="mt-1">{{ $log->user ? $log->user->email : 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Section</p>
                                                            <p class="mt-1">{{ ucfirst($log->navigation) }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Action</p>
                                                            <p class="mt-1">{{ ucfirst($log->action) }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Timestamp</p>
                                                        <p class="mt-1">{{ $log->created_at->format('F d, Y h:i:s A') }}</p>
                                                    </div>
                                                    
                                                    @if($log->performance_id)
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Performance ID</p>
                                                        <p class="mt-1">{{ $log->performance_id }}</p>
                                                    </div>
                                                    @endif
                                                    
                                                    @if($log->post_id)
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Post ID</p>
                                                        <p class="mt-1">{{ $log->post_id }}</p>
                                                    </div>
                                                    @endif
                                                    
                                                    @if($log->event_id)
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Event ID</p>
                                                        <p class="mt-1">{{ $log->event_id }}</p>
                                                    </div>
                                                    @endif
                                                    
                                                    @if($log->slide_id)
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Slide ID</p>
                                                        <p class="mt-1">{{ $log->slide_id }}</p>
                                                    </div>
                                                    @endif
                                                    
                                                    @if($log->general_id)
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">General ID</p>
                                                        <p class="mt-1">{{ $log->general_id }}</p>
                                                    </div>
                                                    @endif
                                                    
                                                    @if($log->officer_id)
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Officer ID</p>
                                                        <p class="mt-1">{{ $log->officer_id }}</p>
                                                    </div>
                                                    @endif
                                                    
                                                    @if($log->booking_id)
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Booking ID</p>
                                                        <p class="mt-1">{{ $log->booking_id }}</p>
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="flex">
                                                    <flux:spacer />
                                                    <flux:button variant="primary" flux:close>Close</flux:button>
                                                </div>
                                            </div>
                                        </flux:modal>

                                        <!-- Delete Log Modal Trigger -->
                                        <button 
                                            wire:click="confirmDelete({{ $log->id }})"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
            {{ $logs->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <flux:modal 
        name="confirm-log-delete" 
        class="w-full md:w-96"
        :variant="$isMobile ? 'flyout' : null"
        :position="$isMobile ? 'bottom' : null"
    >
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Log Entry</flux:heading>
                <flux:text class="mt-2">Are you sure you want to delete this log entry? This action cannot be undone.</flux:text>
            </div>
            <div class="flex justify-end gap-4">
                <flux:button 
                    variant="outline"
                    wire:click="closeModal('confirm-log-delete')"
                >
                    Cancel
                </flux:button>
                <flux:button 
                    variant="danger"
                    wire:click="executeDelete"
                >
                    Delete Entry
                </flux:button>
            </div>
        </div>
    </flux:modal>

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