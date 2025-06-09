import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction'; 
import Swiper from 'swiper';

import '@fullcalendar/daygrid/index.cjs';
import 'swiper/css';
import 'swiper/css/pagination';

document.addEventListener('livewire:navigated', () => {
    initSwiper();

    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        selectMirror: true, // Add this for better mobile feedback
        longPressDelay: 50, // Reduce long press delay for mobile
        selectable: true,
        events: (window.events || []).map(event => ({
            ...event,
            allDay: true
        })),
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
            window.selectedEventSppStatus = info.event.extendedProps.spp_status || 'preview';
            
            
            document.getElementById('view-event-modal-trigger').click();
            document.getElementById('view_event_name').value = info.event.title;
            document.getElementById('view_location').value = info.event.extendedProps.location || 'N/A';
            document.getElementById('view_startStr').value = info.event.startStr.split('T')[0];
            document.getElementById('view_endStr').value = info.event.endStr.split('T')[0];
            document.getElementById('view_status').value = info.event.extendedProps.status || 'Upcoming';

            console.log(window.selectedEventSppStatus)

            const eventImage = document.getElementById('view_event_image');
            const imageUrl = info.event.extendedProps.file_data;

            if (imageUrl) {
                eventImage.src = imageUrl;
                eventImage.style.display = 'block';
            } else {
                eventImage.style.display = 'none';
            }

            // Update publish menu item visibility immediately
            updatePublishMenuVisibility();
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
                html: `<div class="text-white rounded ${bgColor}">${info.event.title.length > 8 ? info.event.title.substring(0, 5) + '...' : info.event.title}</div>`
            };
        }
    });

    calendar.render();


    Livewire.on('eventsLoaded', (data) => {
        console.log('Events loaded:', data);
        
        // Handle different parameter formats
        let events;
        if (Array.isArray(data)) {
            events = data;
        } else if (data && Array.isArray(data.events)) {
            events = data.events;
        } else if (data && data[0] && Array.isArray(data[0])) {
            events = data[0]; // Handle when events are passed as first parameter
        } else {
            console.warn('Invalid events format received:', data);
            events = [];
        }

        const allDayEvents = events.map(event => ({
            ...event,
            allDay: true
        }));

        calendar.removeAllEvents();
        calendar.addEventSource(allDayEvents);
        calendar.refetchEvents();
    });
    
    Livewire.on('modalClosed', (modalName) => {
        if (modalName === 'view-event') {
            // Reset the modal content
            const eventImage = document.getElementById('view_event_image');
            eventImage.src = '';
            eventImage.style.display = 'none';
            
            // Clear all form fields
            document.getElementById('view_event_name').value = '';
            document.getElementById('view_location').value = '';
            document.getElementById('view_startStr').value = '';
            document.getElementById('view_endStr').value = '';
            document.getElementById('view_status').value = '';
            
            // Clear stored event data
            window.selectedEventData = null;
            window.selectedEventDataId = null;
            window.selectedEventSppStatus = null;
        }
    });

    Livewire.on('eventUpdated', (updatedEvent) => {
        if (window.selectedEventDataId === updatedEvent.id) {
            document.getElementById('view_event_name').value = updatedEvent.title;
            document.getElementById('view_location').value = updatedEvent.location || 'N/A';
            document.getElementById('view_startStr').value = updatedEvent.start.split('T')[0];
            document.getElementById('view_endStr').value = updatedEvent.end.split('T')[0];
            document.getElementById('view_status').value = updatedEvent.status || 'Upcoming';

            document.getElementById('view-event-modal-trigger').click();
        }
    });

    FilePond.parse(document.body);


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
            console.log('Selected event data:', eventData);
    
            document.getElementById('edit_event_image').src = eventData.extendedProps.file_data || '';
            document.getElementById('edit_event_name').value = eventData.title;
            document.getElementById('edit_location').value = eventData.extendedProps.location || 'N/A';
            document.getElementById('edit_startStr').value = eventData.startStr.split('T')[0];
            document.getElementById('edit_endStr').value = eventData.endStr.split('T')[0];
            document.getElementById('edit_status').value = eventData.extendedProps.status || 'Upcoming';
    
            // Store the event ID for later use
            window.selectedEventDataId = eventData.id;
    
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

        // Update publish menu visibility when dropdown is opened
        if (event.target.closest('[aria-label="Dropdown toggle"]')) {
            // Use setTimeout to ensure the dropdown is rendered before updating visibility
            setTimeout(() => {
                updatePublishMenuVisibility();
            }, 10);
        }
    });

    document.getElementById('save-edit-event').addEventListener('click', function () {
        var updatedTitle = document.getElementById('edit_event_name').value;
        var updatedLocation = document.getElementById('edit_location').value;
    
        if (updatedTitle) {
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
    const sppStatus = el.getAttribute('data-spp_status');

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
            file_data: image,
            spp_status: sppStatus
        },
        startStr: start + 'T00:00:00', // Add time component to match FullCalendar format
        endStr: end + 'T00:00:00',
        id: id
    };
    
    window.selectedEventDataId = id;
    window.selectedEventSppStatus = sppStatus || 'preview';

    document.getElementById('view-event-modal-trigger').click();
    
    // Update publish menu visibility after modal opens
    setTimeout(() => {
        updatePublishMenuVisibility();
    }, 100);
}

// Function to update publish menu item visibility (moved outside for global access)
function updatePublishMenuVisibility() {
    const publishMenuItem = document.querySelector('[data-publish-event]');
    const publishMenuSeparator = publishMenuItem?.previousElementSibling;
    
    if (publishMenuItem) {
        if (window.selectedEventSppStatus === 'preview') {
            publishMenuItem.style.display = 'block';
            if (publishMenuSeparator && publishMenuSeparator.tagName === 'FLUX:MENU.SEPARATOR') {
                publishMenuSeparator.style.display = 'block';
            }
        } else {
            publishMenuItem.style.display = 'none';
            if (publishMenuSeparator && publishMenuSeparator.tagName === 'FLUX:MENU.SEPARATOR') {
                publishMenuSeparator.style.display = 'none';
            }
        }
    }
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