    @php
        use Illuminate\Support\Str;
    @endphp
    <div class="w-full h-full flex flex-col-reverse md:flex-row">
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
                @if ($sortedEvents->isEmpty())
                    <div class="col-span-2 bg-gray-100 h-[40vh] rounded-lg flex items-center justify-center">
                        <span class="text-gray-500">No Events Available</span>
                    </div>
                @endif

                @foreach ($sortedEvents as $event)
                    <div 
                        class="col-span-2 md:col-span-1 border p-3 rounded-lg shadow-sm bg-white dark:bg-zinc-800 dark:border-neutral-700 cursor-pointer"
                        data-event-card
                        data-title="{{ $event['title'] }}"
                        data-location="{{ $event['location'] }}"
                        data-start="{{ \Carbon\Carbon::parse($event['start'])->format('Y-m-d') }}"
                        data-end="{{ \Carbon\Carbon::parse($event['end'])->format('Y-m-d') }}"
                        data-status="{{ $event['status'] }}"
                        data-image="{{ $event['file_data'] ?? '' }}"
                    >
                        <flux:modal.trigger name="view-event" >
                            <div class="w-full h-40 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                @if (!empty($event['file_data']))
                                    <img src=" {{ Storage::url($event['file_data']) }} " alt="Event Cover" class="w-full h-full object-cover">
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

        <div class="md:w-1/2 w-full h-[100vh] md:h-full p-2 ">
            <div class="md:grid md:grid-cols-3 h-1/4">
                <div class="swiper-container block md:hidden flex justify-center items-center">
                    <div class="swiper-wrapper">
                        @foreach ($statusCounts as $status => $count)
                            <div class="swiper-slide " data-swiper-autoplay="2500">
                                <div class="flex flex-col items-center justify-center border border-gray-200 dark:border-zinc-700 rounded-xl m-1 shadow-sm p-6 bg-white dark:bg-zinc-800 transition-all hover:shadow-md hover:-translate-y-0.5">
                                    <span class="text-lg font-medium text-gray-700 dark:text-zinc-200 mb-1">{{ $count }} Events</span>
                                    <span class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $status }}</span>
                                    <div class="mt-2 text-center">
                                        @if ($status === 'Upcoming')
                                            <span class="text-sm px-3 py-1 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-200">Plan ahead for these events!</span>
                                        @elseif ($status === 'Ongoing')
                                            <span class="text-sm px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-200">Happening now, don't miss out!</span>
                                        @elseif ($status === 'Completed')
                                            <span class="text-sm px-3 py-1 rounded-full bg-gray-100 dark:bg-zinc-700/50 text-gray-600 dark:text-gray-300">These events have concluded.</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            
                <!-- Grid layout for md and up -->
                @foreach ($statusCounts as $status => $count)
                    <div class="hidden md:flex flex-col items-center justify-center border border-gray-200 dark:border-zinc-700 rounded-xl m-1 shadow-sm p-6 bg-white dark:bg-zinc-800 transition-all hover:shadow-md hover:-translate-y-0.5">
                        <span class="text-lg font-medium text-gray-700 dark:text-zinc-200 mb-1">{{ $count }} Events</span>
                        <span class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $status }}</span>
                        <div class="mt-2 text-center">
                            @if ($status === 'Upcoming')
                                <span class="text-sm px-3 py-1 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-200">Plan ahead for these events!</span>
                            @elseif ($status === 'Ongoing')
                                <span class="text-sm px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-200">Happening now, don't miss out!</span>
                            @elseif ($status === 'Completed')
                                <span class="text-sm px-3 py-1 rounded-full bg-gray-100 dark:bg-zinc-700/50 text-gray-600 dark:text-gray-300">These events have concluded.</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="calendar" class="p-2 h-3/4" wire:ignore></div>
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
                    <flux:button id="save-edit-event" variant="primary">Save Changes</flux:button>
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

                    document.getElementById('view_event_image').src = 'http://127.0.0.1:8000/my-uploads/' + imageFileName;


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
                    
                    // Set the event image
                    const eventImage = document.getElementById('view_event_image');
                    if (info.event.extendedProps.cover_photo) {
                        eventImage.src = info.event.extendedProps.cover_photo;
                        eventImage.style.display = 'block';
                    } else {
                        eventImage.style.display = 'none';
                    }
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
            // Only reinitialize if the tab was changed
            if (message.updateQueue.some(update => update.method === 'syncInput' && update.name === 'tab')) {
                initSwiper();
            }
        });
        
    </script>

    
@endscript
