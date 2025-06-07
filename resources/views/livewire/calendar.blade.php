    @php
        $isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
        use Illuminate\Support\Str;
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
            
        </div>


        <div class="w-full flex flex-col-reverse md:flex-row">
            <div class="w-full h-full p-2 md:w-1/2">
                <div class="mt-2 grid grid-cols-2 gap-4 md:max-h-[80vh] overflow-scroll">
                    @if ($sortedEvents->isEmpty())
                        <div class="col-span-2 bg-gray-100 dark:bg-transparent h-[40vh] rounded-lg flex items-center justify-center">
                            <span class="text-gray-500">No Events Available</span>
                        </div>
                    @endif
    
                    @foreach ($sortedEvents as $event)
                        <div 
                            class="col-span-2 border p-3 rounded-lg shadow-sm bg-white dark:bg-zinc-800 dark:border-neutral-700 cursor-pointer"
                            data-event-card
                            data-title="{{ $event['title'] }}"
                            data-location="{{ $event['location'] }}"
                            data-start="{{ \Carbon\Carbon::parse($event['start'])->format('Y-m-d') }}"
                            data-end="{{ \Carbon\Carbon::parse($event['end'])->format('Y-m-d') }}"
                            data-status="{{ $event['status'] }}"
                            data-image="{{ $event['file_data'] }}"
                            data-spp_status="{{ $event['spp_status'] }}"
                            data-id="{{ $event['event_id'] }}"
                        >
                            <flux:modal.trigger name="view-event" >
                                <div class="w-full h-40 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                    @if (!empty($event['file_data']))
                                        <img src=" {{ $event['file_data'] }} " alt="Event Cover" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>No Image</span>
                                        </div>
                                    @endif
                                </div>
                
                                <!-- Event Details -->
                                <div class="mt-4">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ Str::limit($event['title'], 20)}}</h3>
                                        <span class="text-sm px-3 py-1 rounded-full font-medium
                                            {{ $event['status'] === 'Upcoming' ? 'bg-yellow-100 text-yellow-800' : 
                                            ($event['status'] === 'Ongoing' ? 'bg-green-100 text-green-800' : 
                                            'bg-gray-100 text-gray-800') }}">
                                            {{ $event['status'] }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-2 dark:text-white"> Location: {{ $event['location'] }}</p>
                                    <p class="text-sm text-gray-500 dark:text-white"> Start: {{ \Carbon\Carbon::parse($event['start'])->format('F j, Y') }}</p>
                                    <p class="text-sm text-gray-500 dark:text-white"> End: {{ \Carbon\Carbon::parse($event['end'])->format('F j, Y') }}</p>
                                </div>
                            </flux:modal.trigger>
                        </div>
                        @endforeach
                        
                        
                        {{ $sortedEvents->links() }} <!-- Livewire will render pagination links -->
                    </div>
                </div>
                
                <div class="md:w-1/2 w-full h-3/4 bg-white dark:bg-red-900/20 rounded-xl shadow-sm border border-gray-200 dark:border-red-800/30 p-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Calendar</h2>
                    <div id="calendar" class="p-2 h-3/4" wire:ignore></div>
                </div>
            </div>

        <flux:modal 
            name="spp-confirmation"
            class="w-full md:w-123"
            :variant="$isMobile ? 'flyout' : null"
            :position="$isMobile ? 'bottom' : null"
        >
            <flux:heading size="lg">Event Review</flux:heading>
            
            <flux:text class="mb-4">
                Your event is saved. Keep it in preview or publish it now?
            </flux:text>
            
            <div class="flex">
                <flux:button variant="filled" class="w-1/2 mx-1" wire:click="modal_close('spp-confirmation')">Keep in Preview</flux:button>
                <flux:button variant="primary" class="w-1/2 mx-1" wire:click="spp_status_save">Publish immediately</flux:button>
            </div>
        </flux:modal>


        {{-- Event Modal --}}
        <flux:modal.trigger id="event-modal-trigger" name="add-event" style="display: none;">
            <flux:button>Add Event</flux:button>
        </flux:modal.trigger>
        
        <flux:modal id="add-event" name="add-event" variant="dialog" class="modal-center md:w-150">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Add New Event</flux:heading>
                    <flux:text class="mt-2">Enter details for your new calendar event.</flux:text>
                </div>
                <flux:input id="event_name" label="Event Title" placeholder="Enter event title" />
                <flux:input id="location" label="Venue" placeholder="Enter venue" />
                <flux:input id="startStr" label="Start Date" value="" />
                <flux:input id="endStr" label="End Date" value="" />
                <flux:label>
                    Photo
                </flux:label>
                <x-inputs.filepond wire:model="fileUpload"/>
                <div class="flex">
                    <flux:spacer />
                    <flux:button id="save-event" variant="primary">Save Event</flux:button>
                </div>
            </div>
        </flux:modal>

        <flux:modal.trigger id="view-event-modal-trigger" name="view-event" style="display: none;">
            <flux:button>View Event</flux:button>
        </flux:modal.trigger>
        <flux:modal id="view-event" name="view-event" variant="flyout" class="modal-center w-full sm:max-w-sm md:w-200">
            <div class="space-y-6">
                <div class="relative">
                    <flux:heading size="lg">Event Details</flux:heading>
                    <flux:text class="mt-2">View the details of the selected event.</flux:text>
                    <flux:dropdown class="absolute top-0 right-4 sm:right-1">
                        <flux:button icon="dots-horizontal" class="border-none"></flux:button>
                        <flux:menu>
                            @isset($event)
                                @if($event['spp_status'] === 'preview')
                                    <flux:menu.item icon="pen" data-publish-event>Publish</flux:menu.item>
                                    <flux:menu.separator />
                                @endif
                            @endisset
                            <flux:menu.item icon="pen" data-edit-event>Edit</flux:menu.item>
                            <flux:menu.separator />
                            <flux:menu.item variant="danger" icon="trash" data-delete-event>Delete</flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </div>

                <!-- Event Image -->
                <div class="w-full h-48 bg-gray-200 rounded-lg overflow-hidden">
                    <img id="view_event_image" src="" alt="Event Cover" class="w-full h-full object-cover">
                </div>

                <flux:input id="view_event_name" label="Event Title" value="" disabled />
                <flux:input id="view_location" label="Venue" value="" disabled />
                <flux:input id="view_startStr" label="Start Date" value="" disabled />
                <flux:input id="view_endStr" label="End Date" value="" disabled />
                <flux:input id="view_status" label="Status" value="" disabled />
                <div class="flex">
                    <flux:spacer />
                    <flux:button id="close-view-modal" variant="primary">Close</flux:button>
                </div>
            </div>
        </flux:modal>


        {{-- Edit Event Modal --}}
        <flux:modal.trigger id="edit-event-modal-trigger" name="edit-event" style="display: none;">
            <flux:button>Edit Event</flux:button>
        </flux:modal.trigger>

        <flux:modal 
            id="edit-event" 
            name="edit-event" 
            data-modal-name="edit-event"
            variant="dialog" 
            class="modal-center md:w-150"
        >
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Edit Event</flux:heading>
                    <flux:text class="mt-2">Modify details for your event.</flux:text>
                </div>
                <flux:input id="edit_event_name" label="Event Title" placeholder="Enter event title" />
                <flux:input id="edit_location" label="Venue" placeholder="Enter venue" />
                <flux:input id="edit_startStr" label="Start Date" value="" disabled />
                <flux:input id="edit_endStr" label="End Date" value="" disabled />
                <flux:input id="edit_status" label="Status" value="" disabled />
                <div class="flex">
                    <flux:spacer />
                    <div class="flex justif-between w-full">
                        <flux:button wire:click="modal_close('edit-event')" class="w-1/2 mx-1" variant="filled">Cancel</flux:button>
                        <flux:button id="save-edit-event" class="w-1/2 mx-1" variant="primary">Save Changes</flux:button>
                    </div>
                </div>
            </div>
        </flux:modal>

        <flux:modal.trigger id="delete-event-modal-trigger" name="delete-event" style="display: none;">
            <flux:button>Delete Event</flux:button>
        </flux:modal.trigger>

        <flux:modal 
            id="delete-event" 
            name="delete-event" 
            data-modal-name="delete-event"
            variant="dialog" 
            class="modal-center md:w-150"
        >
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Delete Event</flux:heading>
                    <flux:text class="mt-2">Are you sure you want to delete this event?</flux:text>
                </div>
                <div class="flex">
                    <flux:spacer />
                    <div class="flex justify-between w-full">
                        <flux:button wire:click="modal_close('delete-event')" class="w-1/2 mx-1" variant="filled">Cancel</flux:button>
                        <flux:button id="save-delete-event" class="w-1/2 mx-1" variant="primary">Delete</flux:button>
                    </div>
                </div>
            </div>
        </flux:modal>

    </div>

    @script
    <script type="text/javascript">
        document.addEventListener('livewire:navigated', () => {
            initSwiper();

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                events: @json($events),
                select: function (info) {
                    window.selectedEventRange = info;

                    document.getElementById('event_name').value = '';
                    document.getElementById('location').value = '';
                    document.getElementById('startStr').value = info.startStr;
                    document.getElementById('endStr').value = info.endStr;

                    document.getElementById('startStr').setAttribute('disabled', 'disabled');
                    document.getElementById('endStr').setAttribute('disabled', 'disabled');

                    document.getElementById('event-modal-trigger').click();
                },
                eventClick: function (info) {
                    window.selectedEventData = info.event;
                    window.selectedEventDataId = info.event.id;
                    document.getElementById('view-event-modal-trigger').click();
                    document.getElementById('view_event_name').value = info.event.title;
                    document.getElementById('view_location').value = info.event.extendedProps.location || 'N/A';
                    document.getElementById('view_startStr').value = info.event.startStr.split('T')[0];
                    document.getElementById('view_endStr').value = info.event.endStr.split('T')[0];
                    document.getElementById('view_status').value = info.event.extendedProps.status || 'Upcoming';

                    window.selectedEventSppStatus = info.event.extendedProps.spp_status || 'preview'; // Default to 'preview' if not set

                    const eventImage = document.getElementById('view_event_image');
                    const imageUrl = info.event.extendedProps.file_data;

                    if (imageUrl) {
                        eventImage.src = imageUrl;
                        eventImage.style.display = 'block';
                    } else {
                        eventImage.style.display = 'none';
                    }

                    // console.log(eventImage)
                },
                eventContent: function(info) {
                    let bgColor;
                    if (info.event.extendedProps.status === 'Upcoming') {
                        bgColor = 'bg-yellow-500';
                    } else if (info.event.extendedProps.status === 'Completed') {
                        bgColor = 'bg-gray-500';
                    } else if (info.event.extendedProps.status === 'Ongoing') {
                        bgColor = 'bg-green-500';
                    }

                    return {
                        html: `<div class="text-white rounded ${bgColor}">${info.event.title.length > 20 ? info.event.title.substring(0, 20) + '...' : info.event.title}</div>`
                    };
                }
            });

            calendar.render();


            document.getElementById('save-event').addEventListener('click', function() {
                var title = document.getElementById('event_name').value;
                var location = document.getElementById('location').value;
                if (title) {
                    Livewire.dispatch("addEvent", {
                        title: title,
                        location: location,
                        start: window.selectedEventRange.startStr,
                        end: window.selectedEventRange.endStr
                    });
                }
            });

            document.addEventListener('click', function (event) {
                if (event.target.closest('[data-edit-event]')) {
                    const eventData = window.selectedEventData;

                    document.getElementById('edit_event_name').value = eventData.title;
                    document.getElementById('edit_location').value = eventData.extendedProps.location || 'N/A';
                    document.getElementById('edit_startStr').value = eventData.startStr.split('T')[0];
                    document.getElementById('edit_endStr').value = eventData.endStr.split('T')[0];
                    document.getElementById('edit_status').value = eventData.extendedProps.status || 'Upcoming';

                    document.getElementById('edit-event-modal-trigger').click();
                }

                if (event.target.closest('[data-delete-event]')) {
                    const eventData = window.selectedEventData;

                    document.getElementById('delete-event-modal-trigger').click();
                }

                if (event.target.closest('[data-publish-event]')) {
                    const eventData = window.selectedEventData;
                    
                    document.getElementById('publish_event_name').value = eventData.title;
                    document.getElementById('publish_event_id').value = eventData.id;

                    document.getElementById('publish-event-modal-trigger').click();
                }

                if (event.target.closest('[aria-label="Dropdown toggle"]')) {
                    const publishMenuItem = document.querySelector('[data-publish-event]');
                    
                    if (window.selectedEventSppStatus === 'preview') {
                        publishMenuItem.style.display = 'block';
                    } else {
                        publishMenuItem.style.display = 'none';
                    }
                }
            });

            document.getElementById('save-edit-event').addEventListener('click', function () {
                var updatedTitle = document.getElementById('edit_event_name').value;
                var updatedLocation = document.getElementById('edit_location').value;

                
                if (updatedTitle) {
                    console.log('this is the id' , window.selectedEventDataId);
                    Livewire.dispatch("updateEvent", {
                        data: {
                            id: window.selectedEventDataId,
                            title: updatedTitle,
                            location: updatedLocation,
                            start: window.selectedEventData.startStr,
                            end: window.selectedEventData.endStr,
                        }
                    });
                }
            });



            document.getElementById('save-delete-event').addEventListener('click', function () {
                Livewire.dispatch("deleteEvent", {
                    data: {
                        id: window.selectedEventDataId,
                    }
                });
            });

            document.getElementById('confirm-publish-event').addEventListener('click', function () {
                var eventId = document.getElementById('publish_event_id').value;
                
                if (eventId) {
                    Livewire.dispatch("publishEvent", {
                        data: {
                            id: eventId,
                        }
                    });
                }
            });


            document.getElementById('close-view-modal').addEventListener('click', function() {
                Livewire.dispatch('close-flux-modal', { name: 'view-event' });
            });

            window.addEventListener('error', (event) => {
                console.error('Global error caught:', event.error);
            });

            Livewire.on('eventLoaded', (events) => {
                calendar.removeAllEvents();
                calendar.addEventSource(events);
            });

            Livewire.on('eventUpdated', (updatedEvent) => {
                if (window.selectedEventDataId === updatedEvent.id) {
                    document.getElementById('view_event_name').value = updatedEvent.title;
                    document.getElementById('view_location').value = updatedEvent.location || 'N/A';
                    document.getElementById('view_startStr').value = updatedEvent.start.split('T')[0];
                    document.getElementById('view_endStr').value = updatedEvent.end.split('T')[0];
                    document.getElementById('view_status').value = updatedEvent.status || 'Upcoming';

                    // Re-open the view modal
                    document.getElementById('view-event-modal-trigger').click();
                }
            });
            FilePond.parse(document.body);
        });

        document.addEventListener('click', function (e) {
            const card = e.target.closest('[data-event-card]');
            if (card) {
                openEventModal(card);
            }
        });


        function openEventModal(el) {
            const title = el.getAttribute('data-title');
            const location = el.getAttribute('data-location');
            const start = el.getAttribute('data-start');
            const end = el.getAttribute('data-end');
            const status = el.getAttribute('data-status');
            const image = el.getAttribute('data-image');
            const id = el.getAttribute('data-id');

            // Set the values in the view modal
            document.getElementById('view_event_name').value = title;
            document.getElementById('view_location').value = location;
            document.getElementById('view_startStr').value = start;
            document.getElementById('view_endStr').value = end;
            document.getElementById('view_status').value = status;

            // Set the event image
            const eventImage = document.getElementById('view_event_image');
            if (image) {
                eventImage.src = image;
                eventImage.style.display = 'block';
            } else {
                eventImage.style.display = 'none';
            }

            // Create a mock event object similar to FullCalendar's structure
            window.selectedEventData = {
                title: title,
                extendedProps: {
                    location: location,
                    status: status,
                    file_data: image
                },
                startStr: start + 'T00:00:00', // Add time component to match FullCalendar format
                endStr: end + 'T00:00:00',
                id: id
            };
            
            window.selectedEventDataId = id;

            document.getElementById('view-event-modal-trigger').click();
        }
        let swiperInstance = null;

        function initSwiper() {
            const swiperContainer = document.querySelector('.swiper-container');
            
            // Destroy existing swiper instance if it exists
            if (swiperInstance) {
                swiperInstance.destroy(true, true);
                swiperInstance = null;
            }
            
            if (swiperContainer) {
                swiperInstance = new Swiper(swiperContainer, {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    bulletActiveClass: 'swiper-pagination-bullet-active',
                    bulletClass: 'swiper-pagination-bullet',
                });
            }
        }

        Livewire.hook('message.processed', (message, component) => {
            if (message.updateQueue.some(update => update.method === 'syncInput' && update.name === 'tab')) {
                initSwiper();
            }
        });
        
    </script>

    
@endscript
