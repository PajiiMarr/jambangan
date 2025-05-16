@php
    $isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
    // dd($isMobile);
@endphp

<div class="w-full h-full mt-2">
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
                                    class="p-4 rounded-lg border border-gray-200 dark:border-red-800/30 hover:shadow-md transition-shadow duration-200 cursor-pointer
                                    {{ $booking->status === 'upcoming' ? 'bg-blue-50/50 dark:bg-blue-900/20' : 
                                       ($booking->status === 'ongoing' ? 'bg-emerald-50/50 dark:bg-emerald-900/20' : 
                                       'bg-gray-50/50 dark:bg-gray-900/20') }}"
                                    wire:click="$set('selectedBooking', {{ $booking->id }})"
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
                                        {{ $booking->start_date->format('M d, Y H:i') }}
                                    </div>
                                    @if($booking->end_date)
                                    <div class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ $booking->end_date->format('M d, Y H:i') }}
                                    </div>
                                    @endif
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
                <flux:heading size="lg">Booking Details</flux:heading>
                <flux:text>You cannot book that has book in the same date</flux:text>
            </div>
            
        </flux:modal>

        <flux:modal
            id="booking-modal" 
            name="booking-modal"
            data-modal-name="booking-modal"
            variant="dialog" 
            class="modal-center md:w-123"
        >    
        <div class="space-y-4">
            <div>
                <flux:heading size="lg">Booking Details</flux:heading>
            </div>

            {{ $name }}

    
            <flux:input id="modal_booking_name" wire:model.live="name" label="Name" value="" placeholder="Full name of the requester" />
            <flux:input id="modal_booking_email" wire:model="email" label="Email" value="" placeholder="example@example.com" />
            <flux:input id="modal_booking_phone" wire:model="phone" label="Phone" value="" placeholder="Phone number" />
            <flux:input id="modal_booking_event_type" wire:model="event_type" label="Event Type" value="" placeholder="Type of event (e.g. Wedding, Seminar)"  />
            <flux:input id="modal_booking_start_date" wire:model="event_start_date" label="Start Date" value="" placeholder="YYYY-MM-DD" disabled />
            <flux:input id="modal_booking_end_date" wire:model="event_end_date" label="End Date" value="" placeholder="YYYY-MM-DD" disabled />
            <flux:textarea id="modal_booking_message" wire:model="message" label="Message" value="" placeholder="Additional message or request" />
            
            <div class="flex justify-between w-full">
                <flux:button wire:click="modal_close('booking-modal')" class="w-1/2 mx-1" variant="filled">Close</flux:button>
                <flux:button wire:click="save" class="w-1/2 mx-1" variant="primary">Add</flux:button>
            </div>
        </div>
    </flux:modal>
    </div>
</div>

@script
<script type="text/javascript">
    document.addEventListener('livewire:navigated', function() {
    var calendarEl = document.getElementById('bookings-calendar');
    if (!calendarEl) return;
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        events: @json($events),
        select: function (info){
            console.log(info)
            document.getElementById('modal_booking_name').value = '';
            document.getElementById('modal_booking_email').value = '';
            document.getElementById('modal_booking_phone').value = '';
            document.getElementById('modal_booking_event_type').value = '';
            document.getElementById('modal_booking_start_date').value = info.startStr;
            document.getElementById('modal_booking_end_date').value = info.endStr;
            document.getElementById('modal_booking_message').value = '';
            
            document.getElementById('booking-modal-trigger').click();
        },
        eventClick: function(info) {
            console.log(info)
            const props = info.event.extendedProps;
            
            document.getElementById('modal_booking_name').value = info.event.title || 'N/A';
            document.getElementById('modal_booking_email').value = props.email || 'N/A';
            document.getElementById('modal_booking_phone').value = props.phone || 'N/A';
            document.getElementById('modal_booking_event_type').value = props.event_type || 'N/A';
            document.getElementById('modal_booking_start_date').value = info.event.start ? info.event.start.toISOString().split('T')[0] : 'N/A';
            document.getElementById('modal_booking_end_date').value = info.event.end ? info.event.end.toISOString().split('T')[0] : 'N/A';
            document.getElementById('modal_booking_status').value = props.status || 'N/A';
            document.getElementById('modal_booking_message').value = props.message || 'N/A';
            
            if (window.Flux && window.Flux.Modal) {
                window.Flux.Modal.toggle('booking-modal');
            } else {
                const modalTrigger = document.getElementById('booking-modal-trigger');
                if (modalTrigger) {
                    modalTrigger.click();
                }
                
                const modal = document.querySelector('[data-modal-name="booking-modal"]');
                if (modal && typeof modal.show === 'function') {
                    modal.show();
                }
            }
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
});
</script>
@endscript