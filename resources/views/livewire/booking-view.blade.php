<div>
    <!-- View Booking Modal -->
    <div x-data="{ show: @entangle('showViewModal') }" x-show="show" x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="show" x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-[#121212] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <!-- Modal content -->
                <div class="bg-[#121212] px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-white mb-4">
                                Booking Details
                            </h3>
                            @if($viewingBooking)
                            <div class="mt-4 space-y-4">
                                <div class="border-b border-gray-700 pb-3">
                                    <p class="text-sm font-medium text-gray-400">Full Name</p>
                                    <p class="mt-1 text-white">{{ $viewingBooking->name }}</p>
                                </div>
                                
                                <div class="border-b border-gray-700 pb-3">
                                    <p class="text-sm font-medium text-gray-400">Email Address</p>
                                    <p class="mt-1 text-white">{{ $viewingBooking->email }}</p>
                                </div>
                                
                                <div class="border-b border-gray-700 pb-3">
                                    <p class="text-sm font-medium text-gray-400">Phone Number</p>
                                    <p class="mt-1 text-white">{{ $viewingBooking->phone }}</p>
                                </div>
                                
                                <div class="border-b border-gray-700 pb-3">
                                    <p class="text-sm font-medium text-gray-400">Event Date</p>
                                    <p class="mt-1 text-white">{{ $viewingBooking->event_date->format('F d, Y') }}</p>
                                </div>
                                
                                <div class="border-b border-gray-700 pb-3">
                                    <p class="text-sm font-medium text-gray-400">Event Type</p>
                                    <p class="mt-1 text-white capitalize">{{ $viewingBooking->event_type }}</p>
                                </div>
                                
                                <div class="border-b border-gray-700 pb-3">
                                    <p class="text-sm font-medium text-gray-400">Status</p>
                                    <p class="mt-1">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                                            @if($viewingBooking->status === 'pending')
                                                bg-yellow-400/20 text-yellow-400
                                            @elseif($viewingBooking->status === 'approved')
                                                bg-green-400/20 text-green-400
                                            @elseif($viewingBooking->status === 'rejected')
                                                bg-red-400/20 text-red-400
                                            @else
                                                bg-gray-400/20 text-gray-400
                                            @endif">
                                            {{ ucfirst($viewingBooking->status) }}
                                        </span>
                                    </p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-400">Additional Details</p>
                                    <p class="mt-1 text-white whitespace-pre-wrap">{{ $viewingBooking->message ?? 'No additional details provided.' }}</p>
                                </div>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <p class="text-gray-400">No booking selected</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Modal footer -->
                <div class="bg-[#121212] px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="$set('showViewModal', false)"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-700 shadow-sm px-4 py-2 bg-[#121212] text-base font-medium text-gray-300 hover:bg-black/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 sm:mt-0 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div> 