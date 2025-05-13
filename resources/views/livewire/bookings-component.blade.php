<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 bg-white rounded-xl dark:bg-[#121212] p-4 shadow" wire:poll.5s>
        <!-- Flash Message -->
        @if (session()->has('message'))
            <div class="mb-4 rounded-lg bg-green-400/20 p-4 text-green-400">
                {{ session('message') }}
            </div>
        @endif

        <!-- Search & Filter Header -->
        <div class="flex items-center justify-between">
            <div class="relative w-full max-w-xs">
                <input 
                    type="text" 
                    wire:model.live="search"
                    placeholder="Search bookings..." 
                    class="w-full rounded-lg bg-black/50 border border-gray-700 px-4 py-2 pl-10 text-white placeholder-gray-400 focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50"
                >
                <div class="absolute left-3 top-2.5">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <button 
                wire:click="openModal"
                class="ml-4 rounded-lg bg-gradient-to-r from-yellow-400 to-red-500 hover:from-red-500 hover:to-yellow-400 text-black hover:text-white px-4 py-2 text-sm font-medium transition-all duration-300 transform hover:scale-105">
                Add Booking
            </button>
        </div>

        <!-- Bookings Table -->
        <div class="overflow-x-auto rounded-lg border border-gray-700 bg-white dark:bg-[#121212] shadow">
            <table class="min-w-full divide-y divide-gray-700 text-sm">
                <thead class="dark:bg-black/50">
                    <tr class="dark:hover:bg-gray transition-colors duration-300">
                        <th class="px-6 py-3 text-left font-medium text-black dark:text-white uppercase cursor-pointer hover:text-yellow-400 transition-colors duration-300" wire:click="sortBy('name')">
                            Name
                            @if($sortField === 'name')
                                @if($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-black dark:text-white font-medium uppercase cursor-pointer hover:text-yellow-400 transition-colors duration-300" wire:click="sortBy('email')">
                            Email
                            @if($sortField === 'email')
                                @if($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-black dark:text-white font-medium uppercase cursor-pointer hover:text-yellow-400 transition-colors duration-300" wire:click="sortBy('event_date')">
                            Event Date
                            @if($sortField === 'event_date')
                                @if($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-black dark:text-white font-medium uppercase cursor-pointer hover:text-yellow-400 transition-colors duration-300" wire:click="sortBy('event_type')">
                            Event Type
                            @if($sortField === 'event_type')
                                @if($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-black dark:text-white font-medium uppercase cursor-pointer hover:text-yellow-400 transition-colors duration-300" wire:click="sortBy('status')">
                            Status
                            @if($sortField === 'status')
                                @if($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </th>
                        <th class="px-6 py-3 text-right text-black dark:text-white font-medium uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($bookings as $booking)
                        <tr class="dark:hover:bg-gray transition-colors duration-300">
                            <td class="px-6 py-4 text-black dark:text-gray-200 hover:text-yellow-400 transition-colors duration-300">{{ $booking->name }}</td>
                            <td class="px-6 py-4 text-black dark:text-gray-200 hover:text-yellow-400 transition-colors duration-300">{{ $booking->email }}</td>
                            <td class="px-6 py-4 text-black dark:text-gray-200 hover:text-yellow-400 transition-colors duration-300">{{ $booking->event_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-black dark:text-gray-200 hover:text-yellow-400 transition-colors duration-300 capitalize">{{ $booking->event_type }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                                        @if($booking->status === 'pending')
                                            bg-yellow-400/20 text-yellow-400
                                        @elseif($booking->status === 'approved')
                                            bg-green-400/20 text-green-400
                                        @elseif($booking->status === 'rejected')
                                            bg-red-400/20 text-red-400
                                        @else
                                            bg-gray-400/20 text-gray-400
                                        @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" class="text-gray-400 hover:text-yellow-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 rounded-md shadow-lg bg-[#121212] border border-gray-700 z-10">
                                            <div class="py-1">
                                                <button wire:click="updateStatus({{ $booking->id }}, 'pending')" class="block w-full px-4 py-2 text-left text-sm text-yellow-400 hover:bg-black/50">Pending</button>
                                                <button wire:click="updateStatus({{ $booking->id }}, 'approved')" class="block w-full px-4 py-2 text-left text-sm text-green-400 hover:bg-black/50">Approved</button>
                                                <button wire:click="updateStatus({{ $booking->id }}, 'rejected')" class="block w-full px-4 py-2 text-left text-sm text-red-400 hover:bg-black/50">Rejected</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-blue-400 hover:text-blue-300 mr-2 transition-colors duration-300" wire:click="viewBooking({{ $booking->id }})">
                                    View
                                </button>
                                <button class="text-yellow-400 hover:text-yellow-300 mr-2 transition-colors duration-300" wire:click="editBooking({{ $booking->id }})">
                                    Edit
                                </button>
                                <button class="text-red-400 hover:text-red-300 transition-colors duration-300" 
                                        x-data
                                        @click="$dispatch('open-delete-modal', { id: {{ $booking->id }} })">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                No bookings found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    </div>

    <!-- Booking Modal -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="show" x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-[#121212] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-[#121212] px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-white mb-4">
                        {{ $editingBooking ? 'Edit Booking' : 'Create New Booking' }}
                    </h3>
                    <form wire:submit.prevent="saveBooking">
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                                <input type="text" wire:model="name" id="name"
                                       class="mt-1 block w-full rounded-md bg-black/50 border-gray-700 text-white shadow-sm focus:border-yellow-400 focus:ring-yellow-400">
                                @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                                <input type="email" wire:model="email" id="email"
                                       class="mt-1 block w-full rounded-md bg-black/50 border-gray-700 text-white shadow-sm focus:border-yellow-400 focus:ring-yellow-400">
                                @error('email') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-300">Phone</label>
                                <input type="tel" wire:model="phone" id="phone"
                                       class="mt-1 block w-full rounded-md bg-black/50 border-gray-700 text-white shadow-sm focus:border-yellow-400 focus:ring-yellow-400">
                                @error('phone') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="event_date" class="block text-sm font-medium text-gray-300">Event Date</label>
                                <input type="date" wire:model="event_date" id="event_date"
                                       class="mt-1 block w-full rounded-md bg-black/50 border-gray-700 text-white shadow-sm focus:border-yellow-400 focus:ring-yellow-400">
                                @error('event_date') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="event_type" class="block text-sm font-medium text-gray-300">Event Type</label>
                                <select wire:model="event_type" id="event_type"
                                       class="mt-1 block w-full rounded-md bg-black/50 border-gray-700 text-white shadow-sm focus:border-yellow-400 focus:ring-yellow-400">
                                    <option value="">Select Event Type</option>
                                    <option value="wedding">Wedding</option>
                                    <option value="corporate">Corporate</option>
                                    <option value="cultural">Cultural</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('event_type') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-300">Message</label>
                                <textarea wire:model="message" id="message" rows="3"
                                         class="mt-1 block w-full rounded-md bg-black/50 border-gray-700 text-white shadow-sm focus:border-yellow-400 focus:ring-yellow-400"></textarea>
                                @error('message') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="bg-[#121212] px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="saveBooking"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-yellow-400 to-red-500 hover:from-red-500 hover:to-yellow-400 text-black hover:text-white text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ $editingBooking ? 'Update' : 'Create' }}
                    </button>
                    <button type="button" wire:click="$set('showModal', false)"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-700 shadow-sm px-4 py-2 bg-[#121212] text-base font-medium text-gray-300 hover:bg-black/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    @include('livewire.booking-view')

    <!-- Delete Confirmation Modal -->
    <div x-data="{ showDeleteModal: false, bookingId: null }"
         x-show="showDeleteModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="delete-modal-title"
         role="dialog"
         aria-modal="true"
         @open-delete-modal.window="showDeleteModal = true; bookingId = $event.detail.id">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="showDeleteModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity"
                 aria-hidden="true"></div>

            <!-- Modal panel -->
            <div x-show="showDeleteModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-[#121212]/95 backdrop-blur-sm rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-[#121212] px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-500/20 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-white" id="delete-modal-title">
                                Delete Booking
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-300">
                                    Are you sure you want to delete this booking? This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-[#121212] px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                            @click="showDeleteModal = false; $wire.deleteBooking(bookingId)"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-500 text-base font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button type="button"
                            @click="showDeleteModal = false"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-700 shadow-sm px-4 py-2 bg-[#121212] text-base font-medium text-gray-300 hover:bg-black/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom pagination styles */
        .pagination {
            @apply flex justify-center space-x-2;
        }
        
        .pagination .page-item {
            @apply inline-flex items-center;
        }
        
        .pagination .page-link {
            @apply px-3 py-1 rounded-lg text-gray-400 hover:text-yellow-400 transition-colors duration-300;
        }
        
        .pagination .active .page-link {
            @apply bg-yellow-400/20 text-yellow-400;
        }
        
        .pagination .disabled .page-link {
            @apply text-gray-600 cursor-not-allowed;
        }

        [x-cloak] { display: none !important; }
    </style>
</div>
