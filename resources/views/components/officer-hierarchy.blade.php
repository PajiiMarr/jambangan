@props(['officers', 'level' => 1, 'parentId' => null])

@php
    // Get officers for current parent
    $currentOfficers = $officers->where('parent_id', $parentId);
@endphp

@if($currentOfficers->count() > 0)
    <div class="flex flex-col items-center space-y-8">
        <!-- Current Level -->
        <div class="flex justify-center {{ $level === 1 ? 'space-x-8' : ($level === 2 ? 'space-x-6' : 'space-x-4') }}">
            @foreach($currentOfficers as $officer)
                <div class="flex flex-col items-center">
                    <!-- Officer Card -->
                    <div class="
                        @switch($level)
                            @case(1) bg-black rounded-lg shadow-xl p-6 @break
                            @case(2) bg-[#1a1a1a] rounded-lg shadow-lg p-5 @break
                            @default bg-[#222222] rounded-lg shadow-md p-4 @break
                        @endswitch
                        transform transition-all duration-300 hover:scale-105 
                        @if($level === 1) hover:shadow-yellow-500/20 @elseif($level === 2) hover:shadow-yellow-500/10 @else hover:shadow-yellow-500/5 @endif
                        mb-4
                    ">
                        <div class="flex flex-col items-center space-y-{{ $level === 1 ? 4 : ($level === 2 ? 3 : 2) }}">
                            @if($officer->media)
                                <img src="{{ 'http://localhost:9000/my-bucket/' . $officer->media->file_data }}" 
                                     alt="{{ $officer->name }}"
                                     class="
                                        @switch($level)
                                            @case(1) w-24 h-24 @break
                                            @case(2) w-20 h-20 @break
                                            @default w-16 h-16 @break
                                        @endswitch
                                        rounded-full object-cover border-2 
                                        @if($level === 1) border-yellow-400 @elseif($level === 2) border-yellow-400/80 @else border-yellow-400/60 @endif
                                     ">
                            @else
                                <div class="
                                    @switch($level)
                                        @case(1) w-24 h-24 @break
                                        @case(2) w-20 h-20 @break
                                        @default w-16 h-16 @break
                                    @endswitch
                                    rounded-full bg-gradient-to-br from-yellow-400 to-red-500 flex items-center justify-center border-2 
                                    @if($level === 1) border-yellow-400 @elseif($level === 2) border-yellow-400/80 @else border-yellow-400/60 @endif
                                ">
                                    <span class="text-white @if($level === 1) text-2xl @elseif($level === 2) text-xl @else text-lg @endif font-bold">J</span>
                                </div>
                            @endif
                            <div class="text-center">
                                <h{{ 6 - min($level, 3) }} class="@if($level === 1) text-xl @elseif($level === 2) text-lg @else text-base @endif font-{{ $level === 1 ? 'bold' : ($level === 2 ? 'semibold' : 'medium') }} text-white">{{ $officer->name }}</h{{ 6 - min($level, 3) }}>
                                <p class="@if($level === 1) text-yellow-400 @elseif($level === 2) text-gray-400 text-sm @else text-gray-500 text-xs @endif">{{ $officer->position }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Children Container -->
                    <div class="mt-4 flex justify-center">
                        <x-officer-hierarchy 
                            :officers="$officers" 
                            :level="$level + 1" 
                            :parentId="$officer->officer_id" 
                        />
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif