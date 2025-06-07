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
                                        text-black 
                                        placeholder-gray-500 
                                        focus:border-yellow-500 
                                        focus:ring-yellow-500
                                        [&_.flux-input-label]:text-yellow-400
                                        [&_.flux-input-label]:dark:text-yellow-300
                                        [&_input]:text-black
                                        [&_input]:placeholder:text-gray-500
                                        [&_[data-flux-label]]:text-black
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
                                        text-black 
                                        placeholder-gray-500 
                                        focus:border-yellow-500 
                                        focus:ring-yellow-500
                                        [&_.flux-input-label]:text-yellow-400
                                        [&_.flux-input-label]:dark:text-yellow-300
                                        [&_input]:text-black
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
                                        text-black 
                                        placeholder-gray-500 
                                        focus:border-yellow-500 
                                        focus:ring-yellow-500
                                        [&_.flux-input-label]:text-yellow-400
                                        [&_.flux-input-label]:dark:text-yellow-300
                                        [&_input]:text-black
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
                                        text-black 
                                        placeholder-gray-500 
                                        focus:border-yellow-500 
                                        focus:ring-yellow-500
                                        [&_.flux-input-label]:text-yellow-400
                                        [&_.flux-input-label]:dark:text-yellow-300
                                        [&_input]:text-black
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
                                        text-black 
                                        placeholder-gray-500 
                                        focus:border-yellow-500 
                                        focus:ring-yellow-500
                                        [&::-webkit-calendar-picker-indicator]:invert
                                        [&::-webkit-calendar-picker-indicator]:brightness-0
                                        [&::-webkit-calendar-picker-indicator]:opacity-50
                                        [&_.flux-input-label]:text-yellow-400
                                        [&_.flux-input-label]:dark:text-yellow-300
                                        [&_input]:text-black
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
                                        text-black 
                                        placeholder-gray-500 
                                        focus:border-yellow-500 
                                        focus:ring-yellow-500
                                        [&::-webkit-calendar-picker-indicator]:invert
                                        [&::-webkit-calendar-picker-indicator]:brightness-0
                                        [&::-webkit-calendar-picker-indicator]:opacity-50
                                        [&_.flux-input-label]:text-yellow-400
                                        [&_.flux-input-label]:dark:text-yellow-300
                                        [&_input]:text-black
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
                                    text-black 
                                    placeholder-gray-500 
                                    focus:border-yellow-500 
                                    focus:ring-yellow-500
                                    [&_.flux-input-label]:text-yellow-400
                                    [&_.flux-input-label]:dark:text-yellow-300
                                    [&_textarea]:text-black
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
        @vite('resources/js/fullcalendar.js')
    @endpush
</div> 