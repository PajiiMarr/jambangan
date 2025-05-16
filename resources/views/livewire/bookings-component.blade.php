@php
    $isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
    // dd($isMobile);
@endphp

<div wire:poll.5s>
    <div class="w-full h-full mt-2">
        <div class="bg-white dark:bg-red-900/20 rounded-xl shadow-sm border border-gray-200 dark:border-red-800/30 p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search" 
                            placeholder="Search bookings..." 
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30"
                        >
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <div class="relative">
                    <select 
                        wire:model.live="tab" 
                        class="appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                    >
                        <option value="Completed">Completed</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Upcoming">Upcoming</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
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
                            <option value="event_date">Event Date</option>
                            <option value="name">Name</option>
                            <option value="event_type">Event Type</option>
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
        
        <div class="w-full">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                @foreach ($statusCounts as $status => $count)
                    <div class="
                        bg-white dark:bg-red-900/20
                        rounded-xl 
                        shadow-sm 
                        p-4 
                        border border-gray-200 dark:border-red-800/30
                        dark:bg-{{ $status === 'Upcoming' ? 'blue-900/20' : ($status === 'Ongoing' ? 'emerald-900/20' : 'zinc-900/20') }} 
                        dark:border-{{ $status === 'Upcoming' ? 'blue-800/30' : ($status === 'Ongoing' ? 'emerald-800/30' : 'zinc-700/30') }}
                    ">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $status }} Events</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $count }}</p>
                            </div>
                            <div class="p-3 rounded-lg
                                {{ $status === 'Upcoming' ? 'bg-blue-100 dark:bg-blue-900/30' : 
                                   ($status === 'Ongoing' ? 'bg-emerald-100 dark:bg-emerald-900/30' : 
                                   'bg-gray-100 dark:bg-zinc-900/30') }}">
                                @if ($status === 'Upcoming')
                                    <svg class="w-6 h-6 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                @elseif ($status === 'Ongoing')
                                    <svg class="w-6 h-6 text-emerald-500 dark:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                                    </svg>
                                @elseif ($status === 'Completed')
                                    <svg class="w-6 h-6 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex flex-col md:flex-row gap-6 w-full">
                <!-- Bookings List -->
                <div class="w-full md:w-1/2">
                    <div class="bg-white dark:bg-red-900/20 rounded-xl shadow-sm border border-gray-200 dark:border-red-800/30 p-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Bookings List</h2>
                        
                        @if($bookings->isEmpty())
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="mt-2 text-gray-500 dark:text-gray-400">No bookings found</p>
                                @if($search)
                                    <p class="mt-1 text-sm text-gray-400">Try adjusting your search or filter criteria</p>
                                @endif
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach ($bookings as $booking)
                                    <div 
                                        class="p-4 rounded-lg border border-gray-200 dark:border-red-800/30 hover:shadow-md transition-shadow duration-200
                                        {{ $booking->status === 'upcoming' ? 'bg-blue-50/50 dark:bg-blue-900/20' : 
                                           ($booking->status === 'ongoing' ? 'bg-emerald-50/50 dark:bg-emerald-900/20' : 
                                           'bg-gray-50/50 dark:bg-gray-900/20') }}"
                                    >
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ $booking->name }}</h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->event_type }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $booking->status === 'upcoming' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : 
                                                   ($booking->status === 'ongoing' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 
                                                   'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $booking->event_date->format('M d, Y') }}
                                        </div>
                                        <div class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $booking->email }}
                                        </div>
                                        <div class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            {{ $booking->phone }}
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="mt-4 flex gap-2">
                                            <button 
                                                wire:click="viewBooking({{ $booking->id }})"
                                                class="px-3 py-1 text-sm bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200"
                                            >
                                                View Details
                                            </button>
                                            
                                            @if($booking->status === 'pending')
                                                <button 
                                                    wire:click="updateStatus({{ $booking->id }}, 'upcoming')"
                                                    class="px-3 py-1 text-sm bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-200"
                                                >
                                                    Accept
                                                </button>
                                                <button 
                                                    wire:click="updateStatus({{ $booking->id }}, 'rejected')"
                                                    class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors duration-200"
                                                >
                                                    Reject
                                                </button>
                                            @elseif($booking->status === 'upcoming')
                                                <button 
                                                    wire:click="updateStatus({{ $booking->id }}, 'ongoing')"
                                                    class="px-3 py-1 text-sm bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors duration-200"
                                                >
                                                    Start Event
                                                </button>
                                            @elseif($booking->status === 'ongoing')
                                                <button 
                                                    wire:click="updateStatus({{ $booking->id }}, 'completed')"
                                                    class="px-3 py-1 text-sm bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition-colors duration-200"
                                                >
                                                    Complete
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $bookings->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- FullCalendar Container -->
                <div class="w-full md:w-1/2">
                    <div class="bg-white dark:bg-red-900/20 rounded-xl shadow-sm border border-gray-200 dark:border-red-800/30 p-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Calendar</h2>
                        <div id="bookings-calendar" wire:ignore></div>
                    </div>
                </div>
            </div>

            <flux:modal.trigger id="booking-warning" name="booking-warning" style="display: none">
                Warning
            </flux:modal.trigger>
            <flux:modal.trigger id="booking-modal-trigger" name="booking-modal" style="display: none">
                View Booking
            </flux:modal.trigger>
            
            <flux:modal
                name="booking-warning"
                class="w-full md:w-123"
                :variant="$isMobile ? 'flyout' : null"
                :position="$isMobile ? 'bottom' : null"
            >
                <div>
                    <flux:heading size="lg">Booking Details</flux:heading>
                    <flux:text>You cannot book that has book in the same date</flux:text>
                </div>
            </flux:modal>

            <dialog 
                wire:ignore.self 
                class="p-6 [:where(&)]:max-w-xl shadow-lg rounded-xl bg-white dark:bg-zinc-800 border border-transparent dark:border-zinc-700 modal-center md:w-123" 
                data-modal="booking-modal" 
                x-data="{ show: false }"
                x-show="show"
                x-on:modal-show.document="
                    if ($event.detail.name === 'booking-modal') {
                        show = true;
                        $el.showModal();
                    }
                " 
                x-on:modal-close.document="
                    if ($event.detail.name === 'booking-modal') {
                        show = false;
                        $el.close();
                    }
                "
                @click.away="show = false; $el.close()"
            >
                <div class="space-y-6">
                    <div class="flex justify-between items-center">
                        <div class="font-medium text-zinc-800 dark:text-white text-base [&:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&]:mt-2" data-flux-heading="">Booking Details</div>
                        <div class="flex items-center gap-4">
                            <span class="px-3 py-1 text-sm rounded-full
                                {{ $selectedBooking && $selectedBooking->status === 'upcoming' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : 
                                   ($selectedBooking && $selectedBooking->status === 'ongoing' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 
                                   ($selectedBooking && $selectedBooking->status === 'completed' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300' :
                                   ($selectedBooking && $selectedBooking->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' :
                                   'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300'))) }}">
                                {{ $selectedBooking ? ucfirst($selectedBooking->status) : 'Pending' }}
                            </span>
                        </div>
                    </div>

                    @if (session()->has('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if($selectedBooking)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="space-y-4">
                                <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Personal Information</h3>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</label>
                                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $selectedBooking->name }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Address</label>
                                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $selectedBooking->email }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number</label>
                                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $selectedBooking->phone }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Event Information -->
                            <div class="space-y-4">
                                <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Event Information</h3>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Event Type</label>
                                            <p class="mt-1 text-gray-900 dark:text-gray-100 capitalize">{{ $selectedBooking->event_type }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Event Date</label>
                                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $selectedBooking->event_date->format('F d, Y') }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</label>
                                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $selectedBooking->created_at->format('F d, Y H:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Details -->
                            <div class="md:col-span-2">
                                <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Additional Details</h3>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Message</label>
                                            <p class="mt-1 text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $selectedBooking->message ?? 'No additional details provided.' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 mt-6">
                            @if($selectedBooking->status === 'pending')
                                <button 
                                    wire:click="updateStatus({{ $selectedBooking->id }}, 'upcoming')"
                                    class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-200"
                                >
                                    Accept Booking
                                </button>
                                <button 
                                    wire:click="updateStatus({{ $selectedBooking->id }}, 'rejected')"
                                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors duration-200"
                                >
                                    Reject Booking
                                </button>
                            @elseif($selectedBooking->status === 'upcoming')
                                <button 
                                    wire:click="updateStatus({{ $selectedBooking->id }}, 'ongoing')"
                                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors duration-200"
                                >
                                    Start Event
                                </button>
                            @elseif($selectedBooking->status === 'ongoing')
                                <button 
                                    wire:click="updateStatus({{ $selectedBooking->id }}, 'completed')"
                                    class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition-colors duration-200"
                                >
                                    Complete Event
                                </button>
                            @endif
                            <button 
                                wire:click="closeModal"
                                class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200"
                            >
                                Close
                            </button>
                        </div>
                    @endif
                </div>

                <div class="absolute top-0 right-0 mt-4 mr-4">
                    <button 
                        type="button" 
                        wire:click="closeModal"
                        class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none h-8 text-sm rounded-md w-8 inline-flex bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white text-zinc-400! hover:text-zinc-800! dark:text-zinc-500! dark:hover:text-white!"
                    >
                        <svg class="shrink-0 [:where(&)]:size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"></path>
                        </svg>
                    </button>
                </div>
            </dialog>
        </div>
    </div>
</div>

@script
<script type="text/javascript">
    document.addEventListener('livewire:navigated', function() {
        initializeCalendar();
    });

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-modal', (modalName) => {
            const modalTrigger = document.getElementById(modalName + '-trigger');
            if (modalTrigger) {
                modalTrigger.click();
            }
        });

        Livewire.on('close-modal', (modalName) => {
            if (window.Flux && window.Flux.Modal) {
                window.Flux.Modal.close(modalName);
            }
        });

        Livewire.on('booking-operation-successful', (eventDetail) => {
            let eventsData = null;
            if (eventDetail && typeof eventDetail === 'object' && eventDetail.events) {
                eventsData = eventDetail.events;
            } else if (Array.isArray(eventDetail) && eventDetail.length > 0 && eventDetail[0] && typeof eventDetail[0] === 'object' && eventDetail[0].events) {
                eventsData = eventDetail[0].events;
            }

            if (eventsData) {
                initializeCalendar(eventsData);
            } else {
                initializeCalendar(); 
            }
        });
    });

    function initializeCalendar(customEvents = null) {
        var calendarEl = document.getElementById('bookings-calendar');
        if (!calendarEl) {
            return;
        }
        
        if (window.calendar) {
            window.calendar.destroy();
        }
        
        const eventsData = customEvents ? customEvents : @json($events);

        window.calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            events: eventsData,
            eventClick: function(info) {
                @this.call('viewBooking', info.event.id);
            },
            eventContent: function(info) {
                let bgColor;
                switch(info.event.extendedProps.status ? info.event.extendedProps.status.toLowerCase() : '') {
                    case 'upcoming': bgColor = 'bg-blue-500'; break;
                    case 'ongoing': bgColor = 'bg-green-500'; break;
                    case 'completed': bgColor = 'bg-gray-500'; break;
                    default: bgColor = 'bg-blue-500';
                }
                
                return {
                    html: `<div class="p-1 text-white text-sm rounded ${bgColor}">
                        ${info.event.title}
                    </div>`
                };
            }
        });
        
        window.calendar.render();
    }
</script>
@endscript