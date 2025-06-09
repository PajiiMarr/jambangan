@php
    $isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
    // dd($isMobile);
    $bookedRanges = \App\Models\Bookings::all()->map(function($b) {
        return [
            'start' => $b->event_start_date,
            'end' => $b->event_end_date
        ];
    });
@endphp

<div class="w-full h-full mt-2">
    <div class="w-full bg-white dark:bg-red-900/20 rounded-xl shadow-sm border border-gray-200 dark:border-red-800/30 p-4 mb-6">
        <div class="w-full flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="w-full md:w-[25%] flex-1">
                <div class="w-full relative">
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

            <div class="w-full md:w-[25%] relative">
                <select 
                    wire:model.live="tab" 
                    class="w-full appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                >
                    <option value="All">All</option>
                    <option value="Completed">Completed</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Upcoming">Upcoming</option>
                    <option value="Pending">Pending</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <!-- Sort -->
            <div class="w-full md:w-[25%] flex gap-3">
                <div class="w-full relative">
                    <select 
                        wire:model.live="sortBy" 
                        class="w-full appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                    >
                        <option value="start_date">Start Date</option>
                        <option value="title">Title</option>
                        <option value="end_date">End Date</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="w-full md:w-[25%] flex gap-3">
                <div class="w-full relative">
                    <select 
                        wire:model.live="perPage" 
                        class="w-full appearance-none rounded-lg border border-gray-200 dark:border-red-800/30 bg-white dark:bg-red-900/10 text-gray-900 dark:text-gray-100 pl-4 pr-10 py-2 focus:border-red-800/50 focus:ring-1 focus:ring-red-800/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-red-900/20 transition-colors duration-200"
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
                    @if($status === 'Upcoming') dark:bg-blue-900/20 dark:border-blue-800/30 @endif
                    @if($status === 'Ongoing') dark:bg-emerald-900/20 dark:border-emerald-800/30 @endif
                    @if($status === 'Completed') bg-red-100 border-red-200 dark:bg-red-900/10 dark:border-red-700/20 @else @if($status === 'Pending') dark:bg-orange-900/20 dark:border-orange-800/30 @endif @endif
                ">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $status }} Events</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $count }}</p>
                        </div>
                        <div class="p-3 rounded-lg
                            @if($status === 'Upcoming') bg-blue-100 dark:bg-blue-900/30 @endif
                            @if($status === 'Ongoing') bg-emerald-100 dark:bg-emerald-900/30 @endif
                            @if($status === 'Completed') bg-red-50 dark:bg-red-900/30 @endif
                            @if($status === 'Pending') bg-orange-100 dark:bg-orange-900/30 @endif
                        ">
                            @if ($status === 'Upcoming')
                                <svg class="w-6 h-6 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @elseif ($status === 'Ongoing')
                                <svg class="w-6 h-6 text-emerald-500 dark:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                                </svg>
                            @elseif ($status === 'Completed')
                                <svg class="w-6 h-6 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @elseif ($status === 'Pending')
                                <svg class="w-6 h-6 text-orange-500 dark:text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                                </svg>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex flex-col md:flex-row gap-6 w-full">
            <!-- Bookings Container -->
            <div class="w-full md:w-1/2">
                <div class="bg-white dark:bg-red-900/20 rounded-xl shadow-sm border border-gray-200 dark:border-red-800/30 p-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Bookings</h2>
                    
                    @if($bookings->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No bookings found</p>
                    @else
                        <div class="space-y-4">
                            @foreach ($bookings as $booking)
                                <div 
                                    class="p-4 rounded-lg border border-gray-200 dark:border-red-800/30 hover:shadow-md transition-shadow duration-200 cursor-pointer"
                                    wire:click="eventClick({{ $booking->id }})"
                                >
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                                {{ $booking->name }}
                                                <span class="
                                                    px-2 py-0.5 rounded-full text-xs font-semibold
                                                    @if($booking->status === 'pending') bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300
                                                    @elseif($booking->status === 'upcoming') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                                    @elseif($booking->status === 'ongoing') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300
                                                    @elseif($booking->status === 'completed') bg-gray-100 text-gray-800 dark:bg-zinc-900/30 dark:text-gray-300
                                                    @endif
                                                ">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->event_type }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $booking->event_start_date }}
                                    </div>
                                    @if($booking->event_end_date)
                                    <div class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ $booking->event_end_date }}
                                    </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
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
                    <div id="bookings-calendar" wire:ignore ></div>
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
                <flux:heading size="lg">Booking Conflict</flux:heading>
                <flux:text>@if (session()->has('error')) {{ session('error') }} @else You cannot book dates that overlap with existing bookings. @endif</flux:text>
            </div>
            
        </flux:modal>

        <flux:modal
            id="booking-modal" 
            name="booking-modal"
            data-modal-name="booking-modal"
            class="md:w-123"
            >    
            <div class="space-y-4">
                <div>
                    <flux:heading size="lg">Booking Details</flux:heading>
                    @if (session()->has('error'))
                        <div class="mt-2 p-3 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>

                <flux:input id="modal_booking_name" wire:model="name" label="Name" placeholder="Full name of the requester" />
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <flux:input id="modal_booking_email" wire:model="email" label="Email" placeholder="example@example.com" />
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <flux:input id="modal_booking_phone" wire:model="phone" label="Phone" placeholder="Phone number" />
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <flux:input id="modal_booking_event_type" wire:model="event_type" label="Event Type" placeholder="Type of event (e.g. Wedding, Seminar)" />
                @error('event_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <flux:input type="date" id="modal_booking_start_date" wire:model="event_start_date" label="Start Date" placeholder="YYYY-MM-DD"/>
                @error('event_start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <flux:input type="date" id="modal_booking_end_date" wire:model="event_end_date" label="End Date" placeholder="YYYY-MM-DD"/>
                @error('event_end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <flux:textarea id="modal_booking_message" wire:model="message" label="Message" placeholder="Additional message or request" />
                @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                
                <div class="flex justify-between w-full">
                    <flux:button wire:click="modal_close('booking-modal')" class="w-1/2 mx-1" variant="filled">Close</flux:button>
                    <flux:button wire:click="save" class="w-1/2 mx-1" variant="primary">Add</flux:button>
                </div>
            </div>
        </flux:modal>
    </div>



    @if($selectedBooking)
        <flux:modal
            id="booking-details" 
            name="booking-details"
            data-modal-name="booking-details"
            class="w-full md:w-123"
        >    
            <div class="space-y-6">
                <!-- Header -->
                <div class="flex justify-between items-center border-b border-gray-200 dark:border-red-800/30 pb-4">
                    <flux:heading size="lg">Booking Details</flux:heading>
                </div>

                <!-- Content -->
                <div class="space-y-6">
                    <!-- Personal Information -->
                    <div class="bg-gray-50 dark:bg-red-900/10 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:input label="Name" wire:model="name" readonly/>
                            <flux:input label="Email" wire:model="email" readonly/>
                            <flux:input label="Phone" wire:model="phone" readonly/>
                        </div>
                </div>
        
                    <!-- Event Information -->
                    <div class="bg-gray-50 dark:bg-red-900/10 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Event Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input label="Event Type" wire:model="event_type" readonly/>
                <flux:input label="Event Start Date" wire:model="event_start_date" readonly/>
                <flux:input label="Event End Date" wire:model="event_end_date" readonly/>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="bg-gray-50 dark:bg-red-900/10 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Additional Information</h3>
                <flux:input label="Message" wire:model="message" readonly/>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-end gap-2 pt-4 border-t border-gray-200 dark:border-red-800/30">
                    @if($selectedBooking && $selectedBooking->status === 'pending')
                        <flux:button 
                            variant="primary"
                            wire:click="acceptBooking({{ $selectedBooking->id }})"
                        >
                            Accept
                        </flux:button>
                        <flux:button 
                            variant="danger"
                            wire:click="rejectBooking({{ $selectedBooking->id }})"
                        >
                            Reject
                        </flux:button>
                    @endif
                    <flux:button 
                        variant="primary"
                        wire:click="modal_close('booking-details')"
                        onclick="document.getElementById('edit-booking-trigger').click()"
                    >
                        Edit Booking
                    </flux:button>
                    <flux:button 
                        variant="danger"
                        wire:click="modal_close('booking-details')"
                        onclick="document.getElementById('delete-booking-trigger').click()"
                    >
                        Delete Booking
                    </flux:button>
                </div>
            </div>
        </flux:modal>

        <!-- Hidden triggers for edit and delete modals -->
        <flux:modal.trigger id="edit-booking-trigger" name="edit-booking" style="display: none">
            Edit Booking
        </flux:modal.trigger>

        <flux:modal.trigger id="delete-booking-trigger" name="delete-booking" style="display: none">
            Delete Booking
        </flux:modal.trigger>

        <flux:modal
            id="edit-booking"
            name="edit-booking"
            class="w-full md:w-123"
        >
            <div class="space-y-6">
                <!-- Header -->
                <div class="flex justify-between items-center border-b border-gray-200 dark:border-red-800/30 pb-4">
                    <flux:heading size="lg">Edit Booking</flux:heading>
                </div>
                
                <!-- Content -->
                <div class="space-y-6">
                    <!-- Personal Information -->
                    <div class="bg-gray-50 dark:bg-red-900/10 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <flux:input label="Name" wire:model="name"/>
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                <flux:input label="Email" wire:model="email"/>
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                <flux:input label="Phone" wire:model="phone"/>
                                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Event Information -->
                    <div class="bg-gray-50 dark:bg-red-900/10 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Event Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                <flux:input label="Event Type" wire:model="event_type"/>
                                @error('event_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <flux:input type="date" label="Event Start Date" wire:model="event_start_date"/>
                                @error('event_start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <flux:input type="date" label="Event End Date" wire:model="event_end_date"/>
                                @error('event_end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="bg-gray-50 dark:bg-red-900/10 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Additional Information</h3>
                <flux:input label="Message" wire:model="message"/>
                        @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="flex justify-between pt-4 border-t border-gray-200 dark:border-red-800/30">
                    <flux:button 
                        class="w-1/2 mx-1"
                        variant="outline"
                        wire:click="modal_close('edit-booking')"
                    >
                        Cancel
                    </flux:button>
                    <flux:button 
                        class="w-1/2 mx-1"
                        variant="primary"
                        wire:click="updateBooking({{ $selectedBooking->id }})"
                    >
                        Save Changes
                    </flux:button>
                </div>
            </div>
        </flux:modal>

        <flux:modal
            id="delete-booking"
            name="delete-booking"
            class="w-full md:w-123"
        >
            <div class="space-y-6">
                <!-- Header -->
                <div class="flex justify-between items-center border-b border-gray-200 dark:border-red-800/30 pb-4">
                    <flux:heading size="lg">Delete Booking</flux:heading>
                </div>

                <!-- Content -->
                <div class="py-4">
                    <div class="flex items-center justify-center mb-4">
                        <div class="bg-red-100 dark:bg-red-900/30 p-3 rounded-full">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                    <flux:text class="text-center">Are you sure you want to delete this booking? This action cannot be undone.</flux:text>
                </div>

                <!-- Footer -->
                <div class="flex justify-between pt-4 border-t border-gray-200 dark:border-red-800/30">
                    <flux:button 
                        class="w-1/2 mx-1"
                        variant="outline"
                        wire:click="modal_close('delete-booking')"
                    >
                        Cancel
                    </flux:button>
                    <flux:button 
                        class="w-1/2 mx-1"
                        variant="danger"
                        wire:click="deleteBooking({{ $selectedBooking->id }})"
                    >
                        Delete Booking
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    @endif



    
</div>
@script
<script type="text/javascript">
    document.addEventListener('livewire:navigated', function() {
    var calendarEl = document.getElementById('bookings-calendar');
    if (!calendarEl) return;
    
    var bookedRanges = @json($bookedRanges);
    console.log('Initial bookedRanges:', JSON.parse(JSON.stringify(bookedRanges)));
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        events: @json($events),
        selectAllow: function(selectInfo) {
            // Don't allow selecting dates before today
            const today = new Date();
            today.setHours(0,0,0,0);
            if (new Date(selectInfo.startStr) < today) {
                return false;
            }

            function toDateString(date) {
                return date.toISOString().slice(0, 10);
            }
            let selStart = new Date(selectInfo.startStr);
            let selEnd = new Date(selectInfo.endStr);
            selEnd.setDate(selEnd.getDate() - 1); // Make selEnd inclusive

            let selectedDays = [];
            let d = new Date(selStart);
            while (d <= selEnd) {
                selectedDays.push(toDateString(d));
                d.setDate(d.getDate() + 1);
            }

            for (let range of bookedRanges) {
                let bookedStart = new Date(range.start);
                let bookedEnd = new Date(range.end);
                let currentDayInBookedRange = new Date(bookedStart);
                while (currentDayInBookedRange <= bookedEnd) {
                    if (selectedDays.includes(toDateString(currentDayInBookedRange))) {
                        return false; // Found an overlap
                    }
                    currentDayInBookedRange.setDate(currentDayInBookedRange.getDate() + 1);
                }
            }
            return true;
        },
        dayCellDidMount: function(info) {
            const cellDate = new Date(info.date);
            cellDate.setHours(0, 0, 0, 0);

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            // console.log('dayCellDidMount for:', cellDate, 'using bookedRanges:', JSON.parse(JSON.stringify(bookedRanges))); // Optional: very verbose
            const dayNumberEl = info.el.querySelector('.fc-daygrid-day-number');

            // Style past dates
            if (cellDate < today) {
                info.el.classList.add('bg-gray-100', 'dark:bg-gray-800', 'cursor-not-allowed');
                if (dayNumberEl) {
                    dayNumberEl.classList.add('text-gray-400', 'dark:text-gray-500', 'opacity-50');
                }
                return; // Past dates styling takes precedence
            }

            // Check if the date is booked
            let isBooked = false;
            for (const range of bookedRanges) {
                const startDate = new Date(range.start);
                startDate.setHours(0,0,0,0);
                const endDate = new Date(range.end);
                endDate.setHours(0,0,0,0);

                if (cellDate >= startDate && cellDate <= endDate) {
                    isBooked = true;
                    break;
                }
            }

            if (isBooked) {
                info.el.classList.add('bg-red-100', 'dark:bg-red-900/40', 'cursor-not-allowed', 'opacity-75');
                if (dayNumberEl) {
                     dayNumberEl.classList.add('text-red-400', 'dark:text-red-500/70');
                }
            } else {
                // Available, non-past, non-booked dates
                info.el.classList.add('hover:bg-blue-50', 'dark:hover:bg-blue-900/30', 'cursor-pointer');
            }
        },
        select: function (info){
            console.log(info)
            
            // Clear form fields for new booking
            document.getElementById('modal_booking_name').value = '';
            document.getElementById('modal_booking_email').value = '';
            document.getElementById('modal_booking_phone').value = '';
            document.getElementById('modal_booking_event_type').value = '';
            document.getElementById('modal_booking_start_date').value = info.startStr;
            document.getElementById('modal_booking_end_date').value = info.startStr;
            document.getElementById('modal_booking_message').value = '';

            // Dispatch events to update Livewire properties
            document.getElementById('modal_booking_start_date').dispatchEvent(new Event('input'));
            document.getElementById('modal_booking_end_date').dispatchEvent(new Event('input'));
            
            // Open the booking creation modal
            document.getElementById('booking-modal-trigger').click();
        },
        eventClick: function(info) {
            console.log('Event clicked:', info);
            const props = info.event.extendedProps;
            const bookingId = props.id || props.booking_id;
            
            // Call the Livewire method to load the selected booking
            @this.selectedBooking(bookingId).then(() => {
                // After the booking is loaded, open the booking details modal
                if (window.Flux && window.Flux.Modal) {
                    window.Flux.Modal.toggle('booking-details');
                } else {
                    const modalTrigger = document.createElement('button');
                    modalTrigger.setAttribute('data-modal-trigger', 'booking-details');
                    modalTrigger.style.display = 'none';
                    document.body.appendChild(modalTrigger);
                    modalTrigger.click();
                    document.body.removeChild(modalTrigger);
                }
            });
        },
        eventContent: function(info) {
            let bgColor;
            switch(info.event.extendedProps.status) {
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
    
    calendar.render();

    Livewire.on('bookingAdded', () => {
        // After a booking is added, reload page to fully refresh calendar colors
        window.location.reload();
    });

    // Auto-set end date to start date if not set or if start date changes
    document.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'modal_booking_start_date') {
            var startDate = e.target.value;
            var endDateInput = document.getElementById('modal_booking_end_date');
            if (!endDateInput.value || endDateInput.value < startDate) {
                endDateInput.value = startDate;
                endDateInput.dispatchEvent(new Event('input'));
            }
        }
    });
});
</script>
@endscript