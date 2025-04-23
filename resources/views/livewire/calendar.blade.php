    @php
        use Illuminate\Support\Str;

    @endphp
    <div class="w-full flex flex-col md:flex-row">
        <div class="w-full p-2 md:w-1/2">
            <div class="flex space-x-4 border-zinc-200 border-b dark:border-zinc-700">
                <button
                    class="py-2 px-4 text-sm font-medium border-b-2"
                    :class="$wire.tab === 'Completed' ? 'border-accent text-accent' : 'border-transparent text-zinc-500 hover:text-accent'"
                    wire:click="$set('tab', 'Completed')">
                    <i class="fa fa-cog mr-1"></i> {{ __('Completed') }}
                </button>
                <button
                    class="py-2 px-4 text-sm font-medium border-b-2"
                    :class="$wire.tab === 'Ongoing' ? 'border-accent text-accent' : 'border-transparent text-zinc-500 hover:text-accent'"
                    wire:click="$set('tab', 'Ongoing')">
                    <i class="fa fa-paint-brush mr-1"></i> {{ __('Ongoing') }}
                </button>
                <button
                    class="py-2 px-4 text-sm font-medium border-b-2"
                    :class="$wire.tab === 'Upcoming' ? 'border-accent text-accent' : 'border-transparent text-zinc-500 hover:text-accent'"
                    wire:click="$set('tab', 'Upcoming')">
                    <i class="fa fa-bars mr-1"></i> {{ __('Upcoming') }}
                </button>
            </div>

            <div class="mt-2 grid grid-cols-2 gap-4 md:max-h-[80vh] overflow-scroll">
                @empty($sortedEvents)
                    <div class="col-span-2 bg-gray-100 h-1/2 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500">No Events Available</span>

                    </div>
                @endempty

                @foreach ($sortedEvents as $event)
                <div 
                    class="col-span-2 md:col-span-1 border p-3 rounded-lg shadow-sm bg-white dark:bg-zinc-800 dark:border-neutral-700 cursor-pointer"
                    data-event-card
                    data-title="{{ $event['title'] }}"
                    data-location="{{ $event['location'] }}"
                    data-start="{{ \Carbon\Carbon::parse($event['start'])->format('Y-m-d') }}"
                    data-end="{{ \Carbon\Carbon::parse($event['end'])->format('Y-m-d') }}"
                    data-status="{{ $event['status'] }}"
                    {{-- onclick="openEventModal(this)" --}}
                >
                    <flux:modal.trigger name="view-event" >
                        
                        <!-- Event Image or Placeholder -->
                        <div class="w-full h-40 bg-gray-200 rounded-lg flex items-center justify-center">
                            @if (!empty($event['cover_photo']))
                                <img src="{{ $event['cover_photo'] }}" alt="Event Cover" class="w-full h-full object-cover rounded-lg">
                            @else
                                <span class="text-gray-500">No Image</span>
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
            </div>
        </div>

        <div class="w-1/2">
            <div id="calendar" class="p-2" wire:ignore></div>
        </div>    


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


        {{-- Event Details Modal --}}
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
                            <flux:menu.item icon="pen" data-edit-event>Edit</flux:menu.item>

                            <flux:menu.separator />

                            <flux:menu.item variant="danger" icon="trash">Delete</flux:menu.item>

                        </flux:menu>
                    </flux:dropdown>
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
                    <flux:button id="save-edit-event" variant="primary">Save Changes</flux:button>
                </div>
            </div>
        </flux:modal>


    </div>

    @script
    <script type="text/javascript">
        document.addEventListener('livewire:navigated', () => {
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

                    // document.getElementById('view-event-modal-trigger').click();
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


            document.getElementById('close-view-modal').addEventListener('click', function() {
                Livewire.dispatch('close-flux-modal', { name: 'view-event' });
            });


            // Livewire.on('close-flux-modal', (name) => {
            //     console.log('Event name:', name); // Should log "edit-event"
            //     const modal = document.querySelector(`[data-modal-name="${name}"]`);
            //     console.log('Modal:', modal); // Should not be null

            //     if (modal) {
            //         modal.dispatchEvent(new CustomEvent('close'));
            //     } else {
            //         console.error('Modal not found. Check if data-modal-name is correct.');
            //     }
            // });



            // Add a global error handler for additional insights
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

                // Livewire.on('show-event-modal', event => {
                //     window.selectedEventData = event;
                //     window.selectedEventDataId = event.id;

                //     // Fill the modal inputs
                //     document.getElementById('view_event_name').value = event.title;
                //     document.getElementById('view_location').value = event.location || 'N/A';
                //     document.getElementById('view_startStr').value = event.start.split('T')[0];
                //     document.getElementById('view_endStr').value = event.end.split('T')[0];
                //     document.getElementById('view_status').value = event.status || 'Upcoming';

                //     // Open the modal
                //     document.getElementById('view-event-modal-trigger').click();
                // });
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

                document.getElementById('view_event_name').value = title;
                document.getElementById('view_location').value = location;
                document.getElementById('view_startStr').value = start;
                document.getElementById('view_endStr').value = end;
                document.getElementById('view_status').value = status;

                document.getElementById('view-event-modal-trigger').click();
            }

            

            document.addEventListener('livewire:navigated', () => {
                FilePond.parse(document.body);
            });
        </script>
    @endscript
