@php
    $bookedRanges = \App\Models\Bookings::all()->map(function($b) {
        return [
            'start' => $b->event_start_date,
            'end' => $b->event_end_date
        ];
    });
@endphp

<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Booking Form -->
            <div class="lg:col-span-5">
                <div class="bg-[#121212] p-6 sm:p-8 rounded-xl shadow-xl border border-red-900/30">
                    <h2 class="text-xl sm:text-2xl text-white font-extrabold mb-6 relative pl-6 ml-4 sm:ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-2xl sm:before:text-3xl">
                        BOOK A PERFORMANCE
                    </h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <flux:input 
                                    id="modal_booking_name" 
                                    wire:model="name" 
                                    label="Name" 
                                    placeholder="Full name"
                                    class="
                                        bg-[#1a1a1a] 
                                        border-red-900/30 
                                        text-white 
                                        placeholder-gray-500 
                                        focus:border-yellow-500 
                                        focus:ring-yellow-500
                                        [&_.flux-input-label]:text-yellow-400
                                        [&_.flux-input-label]:dark:text-yellow-300
                                        [&_input]:text-white
                                        [&_input]:placeholder:text-gray-500
                                        [&_[data-flux-label]]:text-white
                                    "
                                />
                                @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <flux:input 
                                    id="modal_booking_email" 
                                    wire:model="email" 
                                    label="Email" 
                                    placeholder="example@example.com"
                                    class="
                                        bg-[#1a1a1a] 
                                        border-red-900/30 
                                        text-white 
                                        placeholder-gray-500 
                                        focus:border-yellow-500 
                                        focus:ring-yellow-500
                                        [&_.flux-input-label]:text-yellow-400
                                        [&_.flux-input-label]:dark:text-yellow-300
                                        [&_input]:text-white
                                        [&_input]:placeholder:text-gray-500
                                    "
                                />
                                @error('email') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <flux:input 
                                    id="modal_booking_phone" 
                                    wire:model="phone" 
                                    label="Phone" 
                                    placeholder="Phone number"
                                    class="
                                        bg-[#1a1a1a] 
                                        border-red-900/30 
                                        text-white 
                                        placeholder-gray-500 
                                        focus:border-yellow-500 
                                        focus:ring-yellow-500
                                        [&_.flux-input-label]:text-yellow-400
                                        [&_.flux-input-label]:dark:text-yellow-300
                                        [&_input]:text-white
                                        [&_input]:placeholder:text-gray-500
                                    "
                                />
                                @error('phone') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <flux:input 
                                    id="modal_booking_event_type" 
                                    wire:model="event_type" 
                                    label="Event Type" 
                                    placeholder="Type of event"
                                    class="
                                        bg-[#1a1a1a] 
                                        border-red-900/30 
                                        text-white 
                                        placeholder-gray-500 
                                        focus:border-yellow-500 
                                        focus:ring-yellow-500
                                        [&_.flux-input-label]:text-yellow-400
                                        [&_.flux-input-label]:dark:text-yellow-300
                                        [&_input]:text-white
                                        [&_input]:placeholder:text-gray-500
                                    "
                                />
                                @error('event_type') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <flux:input 
                                    type="date" 
                                    id="modal_booking_start_date" 
                                    wire:model="event_start_date" 
                                    label="Start Date"
                                    class="
                                        bg-[#1a1a1a] 
                                        border-red-900/30 
                                        text-white 
                                        placeholder-gray-500 
                                        focus:border-yellow-500 
                                        focus:ring-yellow-500
                                        [&::-webkit-calendar-picker-indicator]:invert
                                        [&::-webkit-calendar-picker-indicator]:brightness-0
                                        [&::-webkit-calendar-picker-indicator]:opacity-50
                                        [&_.flux-input-label]:text-yellow-400
                                        [&_.flux-input-label]:dark:text-yellow-300
                                        [&_input]:text-white
                                        [&_input]:placeholder:text-gray-500
                                    "
                                />
                                @error('event_start_date') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <flux:input 
                                    type="date" 
                                    id="modal_booking_end_date" 
                                    wire:model="event_end_date" 
                                    label="End Date"
                                    class="
                                        bg-[#1a1a1a] 
                                        border-red-900/30 
                                        text-white 
                                        placeholder-gray-500 
                                        focus:border-yellow-500 
                                        focus:ring-yellow-500
                                        [&::-webkit-calendar-picker-indicator]:invert
                                        [&::-webkit-calendar-picker-indicator]:brightness-0
                                        [&::-webkit-calendar-picker-indicator]:opacity-50
                                        [&_.flux-input-label]:text-yellow-400
                                        [&_.flux-input-label]:dark:text-yellow-300
                                        [&_input]:text-white
                                        [&_input]:placeholder:text-gray-500
                                    "
                                />
                                @error('event_end_date') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <flux:textarea 
                                id="modal_booking_message" 
                                wire:model="message" 
                                label="Additional Details" 
                                placeholder="Any specific requirements or details about your event"
                                class="
                                    bg-[#1a1a1a] 
                                    border-red-900/30 
                                    text-white 
                                    placeholder-gray-500 
                                    focus:border-yellow-500 
                                    focus:ring-yellow-500
                                    [&_.flux-input-label]:text-yellow-400
                                    [&_.flux-input-label]:dark:text-yellow-300
                                    [&_textarea]:text-white
                                    [&_textarea]:placeholder:text-gray-500
                                "
                            />
                            @error('message') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="flex justify-end w-full">
                            <flux:button 
                                wire:click="saveBooking" 
                                class="w-full bg-yellow-600 hover:bg-yellow-500 text-black transition-colors duration-300"
                            >
                                Submit Booking
                            </flux:button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Calendar -->
            <div class="lg:col-span-7">
                <div class="bg-[#121212] p-6 sm:p-8 rounded-xl shadow-xl border border-red-900/30">
                    <h2 class="text-xl sm:text-2xl text-white font-extrabold mb-6 relative pl-6 ml-4 sm:ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-2xl sm:before:text-3xl">
                        AVAILABLE DATES
                    </h2>
                    <div id="public-bookings-calendar" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let bookedRanges = @json($bookedRanges);
            var calendarEl = document.getElementById('public-bookings-calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                height: 'auto',
                selectAllow: function(selectInfo) {
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
                    selEnd.setDate(selEnd.getDate() - 1);
                    let selectedDays = [];
                    let d = new Date(selStart);
                    while (d <= selEnd) {
                        selectedDays.push(toDateString(d));
                        d.setDate(d.getDate() + 1);
                    }
                    for (let range of bookedRanges) {
                        let bookedStart = new Date(range.start);
                        let bookedEnd = new Date(range.end);
                        let currentDay = new Date(bookedStart);
                        while (currentDay <= bookedEnd) {
                            if (selectedDays.includes(toDateString(currentDay))) {
                                return false;
                            }
                            currentDay.setDate(currentDay.getDate() + 1);
                        }
                    }
                    return true;
                },
                dayCellDidMount: function(info) {
                    const cellDate = new Date(info.date);
                    cellDate.setHours(0, 0, 0, 0);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    const dayNumberEl = info.el.querySelector('.fc-daygrid-day-number');
                    
                    // Base styling for calendar cells
                    info.el.classList.add(
                        'transition-all', 
                        'duration-200', 
                        'ease-in-out',
                        'dark:bg-[#1a1a1a]',
                        'bg-white'
                    );

                    if (cellDate < today) {
                        info.el.classList.add(
                            'bg-gray-100', 
                            'dark:bg-gray-900', 
                            'cursor-not-allowed',
                            'opacity-50'
                        );
                        if (dayNumberEl) dayNumberEl.classList.add(
                            'text-gray-400', 
                            'dark:text-gray-600'
                        );
                        return;
                    }
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
                        info.el.classList.add(
                            'bg-red-100', 
                            'dark:bg-red-900/30', 
                            'cursor-not-allowed', 
                            'opacity-75'
                        );
                        if (dayNumberEl) dayNumberEl.classList.add(
                            'text-red-500', 
                            'dark:text-red-300'
                        );
                    } else {
                        info.el.classList.add(
                            'hover:bg-yellow-50', 
                            'dark:hover:bg-yellow-900/20', 
                            'cursor-pointer'
                        );
                    }
                },
                select: function(info) {
                    // Always set start date to the first selected date
                    document.getElementById('modal_booking_start_date').value = info.startStr;
                    
                    // If the selection spans multiple days, set end date to the last day of selection
                    let endDate = new Date(info.endStr);
                    endDate.setDate(endDate.getDate() - 1); // Subtract one day to make it inclusive
                    document.getElementById('modal_booking_end_date').value = endDate.toISOString().slice(0, 10);
                    
                    // Dispatch input events to trigger Livewire updates
                    document.getElementById('modal_booking_start_date').dispatchEvent(new Event('input'));
                    document.getElementById('modal_booking_end_date').dispatchEvent(new Event('input'));
                },
                // Custom styling for calendar
                viewClassNames: function(view) {
                    return [
                        'dark:bg-[#121212]',
                        'dark:text-gray-200',
                        'text-gray-900'
                    ];
                },
                // Custom styling for header
                headerClassNames: function() {
                    return [
                        'dark:bg-[#1a1a1a]',
                        'bg-gray-50',
                        'dark:text-yellow-400',
                        'text-red-800'
                    ];
                }
            });
            calendar.render();

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
    @endpush
</div> 