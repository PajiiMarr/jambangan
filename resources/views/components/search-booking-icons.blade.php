<!-- Search and Booking Icons Component -->
<div class="flex items-center space-x-4">
    <div x-data="{ searchOpen: false }" class="relative">
        <button @click="searchOpen = true" class="group relative cursor-pointer">
            <img src="{{ asset('images/search.svg') }}" 
                 alt="Search" 
                 class="h-8 w-8 transition-all duration-300 group-hover:scale-110 group-hover:rotate-12"
                 :class="searchOpen ? 'opacity-0 scale-0' : 'opacity-100 scale-100'">
            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-red-500 to-yellow-400 transition-all duration-300 group-hover:w-full"></span>
        </button>
        
        <!-- Search Box -->
        <div x-show="searchOpen" 
             @click.away="searchOpen = false"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute right-0 -top-1 w-64">
            <div class="relative">
                <input type="text" 
                       class="w-full rounded-lg bg-transparent border border-white/20 px-4 py-2 pl-10 text-white placeholder-white/50 focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50"
                       placeholder="Search..."
                       x-model="searchQuery"
                       @keyup.enter="performSearch">
                <div class="absolute left-3 top-2">
                    <svg class="h-5 w-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <a href="#booking" class="group relative">
        <img src="{{ asset('images/bookings.svg') }}" alt="Booking" class="h-8 w-8 transition-all duration-300 group-hover:scale-110 group-hover:-rotate-12">
        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-yellow-400 to-red-500 transition-all duration-300 group-hover:w-full"></span>
    </a>
</div> 