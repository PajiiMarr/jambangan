    <div class="flex h-full w-full flex-1 gap-6 rounded-2xl">
        <!-- Left Panel -->
        
        <div class="hidden md:block w-1/2 overflow-auto max-h-full">
            <div class="grid grid-cols-2 w-full overflow-auto max-h-full">
                @if ($performances->isEmpty())
                    <div class="mt-2 col-span-2 p-8 text-center rounded-xl bg-gray-50">
                        <p class="text-gray-500 font-medium">No performances available.</p>
                    </div>
                @else
                    @foreach ($performances as $performance)
                    <div 
                        wire:key="performance-{{ $performance->performance_id }}"
                        wire:click="showPerformance({{ $performance->performance_id }})"
                        class="m-2 rounded-xl shadow-sm hover:shadow-md bg-white relative overflow-hidden h-60 group cursor-pointer transition-all duration-300 border border-gray-100"
                    >
                            @if ($performance->media)
                                <div class="absolute inset-0 w-full h-full transition-transform duration-500 ease-in-out group-hover:scale-105">
                                    <img 
                                        src="{{ $performance->media->file_url }}" 
                                        alt="image" 
                                        class="w-full h-full object-cover" 
                                    />
                                </div>
                            @endif
                        
                            <!-- Gradient overlay -->
                            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/80 via-black/50 to-transparent p-4 z-10">
                                <h2 class="text-lg font-semibold text-white">{{ $performance->title }}</h2>
                            </div>
                        
                            @unless($performance->media)
                                <div class="absolute inset-0 bg-gray-50 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endunless
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        

        <div class="block md:hidden w-full overflow-auto max-h-full">
            <div class="grid grid-cols-1 md:grid-cols-2 w-full overflow-auto max-h-full">
                @if ($performances->isEmpty())
                    <div class="col-span-2 p-8 text-center rounded-xl bg-gray-50">
                        <p class="text-gray-500 font-medium">No performances available.</p>
                    </div>
                @else
                    @foreach ($performances as $performance)
                    <flux:modal.trigger name="performance-details">

                        <div 
                            wire:key="performance-{{ $performance->performance_id }}"
                            wire:click="showPerformance({{ $performance->performance_id }})"
                            class="m-2 rounded-xl shadow-sm hover:shadow-md bg-white relative overflow-hidden h-60 group cursor-pointer transition-all duration-300 border border-gray-100"
                        >
                                @if ($performance->media)
                                    <div class="absolute inset-0 w-full h-full transition-transform duration-500 ease-in-out group-hover:scale-105">
                                        <img 
                                            src="{{ $performance->media->file_url }}" 
                                            alt="image" 
                                            class="w-full h-full object-cover" 
                                        />
                                    </div>
                                @endif
                            
                                <!-- Gradient overlay -->
                                <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/80 via-black/50 to-transparent p-4 z-10">
                                    <h2 class="text-lg font-semibold text-white">{{ $performance->title }}</h2>
                                </div>
                            
                                @unless($performance->media)
                                    <div class="absolute inset-0 bg-gray-50 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endunless
                            </div>
                    </flux:modal.trigger>
                    @endforeach
                @endif
            </div>
        </div>
        

        
        <!-- Right Panel -->
        <div class="hidden md:block w-1/2 p-6 rounded-2xl bg-white shadow-sm border border-gray-100">
            @if ($selectedPerformance)
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-semibold text-2xl text-gray-800">{{ $selectedPerformance->title }}</h2>
            </div>
        
            <div class="space-y-4">
                    <div class="bg-gray-50 rounded-xl p-5">
                        <p class="text-gray-600">{{ $selectedPerformance->description }}</p>
                    </div>
        
                    @if ($selectedPerformance->media)
                        <div class="mt-6 rounded-xl overflow-hidden">
                            <img 
                                src="{{ $selectedPerformance->media->file_url }}" 
                                alt="Selected Performance" 
                                class="w-full max-h-80 object-cover"
                            />
                        </div>
                    @endif
                </div>
            @else
                <div class="rounded-xl bg-gray-50 p-8 flex flex-col items-center justify-center mt-4">
                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                    </svg>
                    <p class="text-gray-500 font-medium">Select a performance to view details</p>
                </div>
            @endif
        </div>
        
        
        <flux:modal name="performance-details" variant="flyout" position="bottom" class="h-full">
            <div class="space-y-4 p-6">
                @if ($selectedPerformance)
                    <h3 class="text-xl font-medium text-gray-800">{{ $selectedPerformance->title }}</h3>

                    <div class="bg-gray-50 rounded-xl p-5">
                        <p class="text-gray-600">{{ $selectedPerformance->description }}</p>
                    </div>

                    @if ($selectedPerformance->media)
                        <div class="mt-6 rounded-xl overflow-hidden">
                            <img 
                                src="{{ $selectedPerformance->media->file_url }}" 
                                alt="Selected Performance" 
                                class="w-full max-h-60 object-cover"
                            />
                        </div>
                    @endif
                @else
                    <p class="text-gray-500 font-medium text-center">No performance selected</p>
                @endif
            </div>
        </flux:modal>

        
    </div>