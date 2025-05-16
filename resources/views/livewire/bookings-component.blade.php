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
                                    class="p-4 rounded-lg border border-gray-200 dark:border-red-800/30 hover:shadow-md transition-shadow duration-200 cursor-pointer"
                                    wire:click="eventClick({{ $booking->id }})"
                                >
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ $booking->name }}</h3>
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
                <flux:heading size="lg">Booking Details</flux:heading>
                <flux:text>You cannot book that has book in the same date</flux:text>
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
                </div>

                <flux:input id="modal_booking_name" wire:model="name" label="Name" placeholder="Full name of the requester" />
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <flux:input id="modal_booking_email" wire:model="email" label="Email" placeholder="example@example.com" />
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <flux:input id="modal_booking_phone" wire:model="phone" label="Phone" placeholder="Phone number" />
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <flux:input id="modal_booking_event_type" wire:model="event_type" label="Event Type" placeholder="Type of event (e.g. Wedding, Seminar)" />
                @error('event_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <flux:input type="date" id="modal_booking_start_date" wire:model="event_start_date" label="Start Date" placeholder="YYYY-MM-DD" readonly/>
                @error('event_start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <flux:input type="date" id="modal_booking_end_date" wire:model="event_end_date" label="End Date" placeholder="YYYY-MM-DD" readonly/>
                @error('event_end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <flux:textarea id="modal_booking_message" wire:model="message" label="Message" placeholder="Additional message or request" />
                @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <flux:dropdown class="w-1/2">
                    <flux:label>Performance</flux:label>
                    <flux:button icon-trailing="chevron-down" class="mt-1 w-full">
                        {{ $selectedPerformanceName }}
                    </flux:button>
                    <flux:menu>
                        <flux:menu.radio.group wire:model.live="selectedPerformance">
                            <flux:menu.radio value="none">
                                None
                            </flux:menu.radio>
                            @foreach($performances as $performance)
                                <flux:menu.radio value="{{ $performance->performance_id }}">
                                    {{ $performance->title }}
                                </flux:menu.radio>
                            @endforeach
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>
                
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
            variant="flyout"
            class="modal-center md:w-123"
        >    
            <div class="space-y-4">
                <div>
                    <flux:heading size="lg">Booking Details</flux:heading>
                </div>

                <div class="relative">
                    <flux:dropdown class="absolute top-0 right-4 sm:right-1">
                        <flux:button icon="dots-horizontal" class="border-none"></flux:button>

                        <flux:menu>
                            <flux:menu.item icon="pen">
                                <flux:modal.trigger name="edit-booking">
                                    Edit
                                </flux:modal.trigger>
                            </flux:menu.item>
                            <flux:menu.separator />

                            <flux:menu.item variant="danger" icon="trash">
                                <flux:modal.trigger name="delete-booking">
                                    Delete
                                </flux:modal.trigger>
                            </flux:menu.item>
                        </flux:menu>

                    </flux:dropdown>
                </div>
        
                <flux:input label="Name" class="mt-3" wire:model="name" readonly/>
                <flux:input label="Email" wire:model="email" readonly/>
                <flux:input label="Phone" wire:model="phone" readonly/>
                <flux:input label="Event Type" wire:model="event_type" readonly/>
                <flux:input label="Event Start Date" wire:model="event_start_date" readonly/>
                <flux:input label="Event End Date" wire:model="event_end_date" readonly/>
                <flux:input label="Message" wire:model="message" readonly/>
        
                <div class="flex justify-end w-full">
                    <flux:button wire:click="modal_close('booking-details')" class="mx-1" variant="filled">Close</flux:button>
                </div>
            </div>
        </flux:modal>


        <flux:modal
            id="edit-booking"
            name="edit-booking"
            class="w-full md:w-123"
            :variant="$isMobile ? 'flyout' : null"
            :position="$isMobile ? 'bottom' : null"
        >
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Edit Booking</flux:heading>
                </div>
                
                <flux:input label="Name" class="mt-3" wire:model="name"/>
                <flux:input label="Email" wire:model="email"/>
                <flux:input label="Phone" wire:model="phone"/>
                <flux:input label="Event Type" wire:model="event_type"/>
                <flux:input label="Event Start Date" wire:model="event_start_date"/>
                <flux:input label="Event End Date" wire:model="event_end_date"/>
                <flux:input label="Message" wire:model="message"/>
                
                <div class="flex justify-between">
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
            :variant="$isMobile ? 'flyout' : null"
            :position="$isMobile ? 'bottom' : null"
        >
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Delete Booking</flux:heading>
                    <flux:text class="mt-2">Are you sure you want to delete this booking? This action cannot be undone.</flux:text>
                </div>
                <div class="flex justify-between">
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
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        events: @json($events),
        select: function (info){
            console.log(info)
            
            // Clear form fields for new booking
            document.getElementById('modal_booking_name').value = '';
            document.getElementById('modal_booking_email').value = '';
            document.getElementById('modal_booking_phone').value = '';
            document.getElementById('modal_booking_event_type').value = '';
            document.getElementById('modal_booking_start_date').value = info.startStr;
            document.getElementById('modal_booking_end_date').value = info.endStr;
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
            // This will set the selectedBooking property in your component
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
        // Refetch events from Livewire
        @this.getEvents().then(events => {
            calendar.removeAllEvents();
            calendar.addEventSource(events);
        });
    });
});
</script>
@endscript