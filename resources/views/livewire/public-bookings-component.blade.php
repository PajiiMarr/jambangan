<div>
    <!-- Success Message -->
    @if(session('success'))
    <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-500 ease-in-out"
         x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-full"
         x-init="() => {
            show = true;
            setTimeout(() => {
                show = false;
            }, 3000);
         }"
         style="position: fixed; top: 20px; right: 20px; margin: 0;">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Booking Form -->
    <div class="bg-[#121212] p-8 rounded-lg shadow-xl">
        <h2 class="text-xl sm:text-2xl text-white font-extrabold mb-6 relative pl-6 ml-4 sm:ml-10 before:content-['|'] before:absolute before:left-0 before:text-[#EAB308] before:text-2xl sm:before:text-3xl">
            REQUEST A BOOKING
        </h2>
        <form wire:submit="saveBooking" class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                <input type="text" id="name" wire:model="name" required
                    class="w-full px-4 py-2 bg-black/50 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                <input type="email" id="email" wire:model="email" required
                    class="w-full px-4 py-2 bg-black/50 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Phone Number</label>
                <input type="tel" id="phone" wire:model="phone" required
                    class="w-full px-4 py-2 bg-black/50 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50">
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="event_date" class="block text-sm font-medium text-gray-300 mb-2">Event Date</label>
                <div class="relative">
                    <input type="date" id="event_date" wire:model="event_date" required
                        class="w-full px-4 py-2 bg-black/50 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 pr-10 [&::-webkit-calendar-picker-indicator]:hidden">
                    <button type="button" onclick="document.getElementById('event_date').showPicker()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-yellow-400 cursor-pointer hover:text-yellow-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                </div>
                @error('event_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="event_type" class="block text-sm font-medium text-gray-300 mb-2">Event Type</label>
                <select id="event_type" wire:model="event_type" required
                    class="w-full px-4 py-2 bg-black/50 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50">
                    <option value="">Select Event Type</option>
                    <option value="wedding">Wedding</option>
                    <option value="corporate">Corporate Event</option>
                    <option value="cultural">Cultural Festival</option>
                    <option value="other">Other</option>
                </select>
                @error('event_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Additional Details</label>
                <textarea id="message" wire:model="message" rows="4"
                    class="w-full px-4 py-2 bg-black/50 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50"></textarea>
                @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <button type="submit"
                class="w-full px-6 py-3 bg-gradient-to-r from-yellow-400 to-red-500 hover:from-red-500 hover:to-yellow-400 text-black hover:text-white rounded-full font-semibold transition-all duration-300 transform hover:scale-105">
                Submit Booking Request
            </button>
        </form>
    </div>
</div> 