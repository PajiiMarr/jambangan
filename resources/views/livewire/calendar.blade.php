<div>
    <div id="calendar" class="p-2" wire:ignore></div>

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

                document.getElementById('view-event-modal-trigger').click();
            },
            eventDidMount: function (info) {
                var status = info.event.extendedProps.status;
                if (status === 'Upcoming') {
                    info.el.style.backgroundColor = '#FFD700'; // Yellow
                    info.el.style.color = '#000'; // Black text for contrast
                } else if (status === 'Ongoing') {
                    info.el.style.backgroundColor = '#28a745'; // Green
                    info.el.style.color = '#fff';
                } else if (status === 'Completed') {
                    info.el.style.backgroundColor = '#6c757d'; // Gray
                    info.el.style.color = '#fff';
                }
            },
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

        });

        

        document.addEventListener('livewire:navigated', () => {
            FilePond.parse(document.body);
        });
    </script>
@endscript
