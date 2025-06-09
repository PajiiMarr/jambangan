@php
    $isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
    // dd($isMobile);
@endphp

<div class="w-full rounded-xl border-neutral-200">
    <flux:modal 
        name="create-post" 
        class="w-full md:w-123"
        :variant="$isMobile ? 'flyout' : null"
        :position="$isMobile ? 'bottom' : null"
    >
        <div class="text-center space-x-3">
            <flux:heading size="lg">
                Create Post
            </flux:heading>
        </div>
        <form wire:submit.prevent="save" method="POST" class="flex flex-col space-y-4">
            @csrf
            <div class="space-y-4">
                <flux:field>
                    <flux:label>Title</flux:label>
                    <flux:input wire:model.blur="title" placeholder="Enter Title" />
                    @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>Content</flux:label>
                    <textarea class="resize-none p-2 border border-neutral-200 rounded-md w-full" wire:model="content" placeholder="Enter content..."></textarea>
                </flux:field>

                <div class="flex w-full justify-between gap-2">
                    <flux:dropdown class="w-1/2">
                        <flux:label>Events</flux:label>
                        <flux:button icon-trailing="chevron-down" class="mt-1 w-full">
                            {{ $selectedEventName }}
                        </flux:button>
                        <flux:menu>
                            <flux:menu.radio.group wire:model.live="selectedEvent">
                                <flux:menu.radio value="none">
                                    None
                                </flux:menu.radio>
                                @foreach($events as $event)
                                    <flux:menu.radio value="{{ $event->event_id }}">
                                        {{ $event->event_name }} | {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}
                                    </flux:menu.radio>
                                @endforeach
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:dropdown class="w-1/2">
                        <flux:label>Performance</flux:label>
                        <flux:button icon-trailing="chevron-down" class="mt-1 w-full">
                            {{ $selectedPerformanceName }}
                        </flux:button>
                        <flux:menu>
                            <flux:menu.radio.group wire:model.live="selectedPerformance">
                                <flux:menu.radio value="none">
                                    None
                                </flux:menu.radio>
                                @foreach($performances as $performance)
                                    <flux:menu.radio value="{{ $performance->performance_id }}">
                                        {{ $performance->title }}
                                    </flux:menu.radio>
                                @endforeach
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>
                </div>

                <div class="w-full">
                    <x-inputs.filepond wire:model='uploadedFiles' multiple />
                    @error('content') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex">
                <flux:button variant="filled" class="w-1/2 mx-1" wire:click="modal_close('create-post')">Close</flux:button>
                <flux:button variant="primary" class="w-1/2 mx-1" type="submit">Post</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal 
        name="spp-confirmation"
        class="w-full md:w-123"
        :variant="$isMobile ? 'flyout' : null"
        :position="$isMobile ? 'bottom' : null"
    >
        <flux:heading size="lg">Post Review</flux:heading>
        
        <flux:text class="mb-4">
            Your post is saved. Keep it in preview or publish it now?
        </flux:text>
        
        <div class="flex">
            <flux:button variant="filled" class="w-1/2 mx-1" wire:click="modal_close('spp-confirmation')">Keep in Preview</flux:button>
            <flux:button variant="primary" class="w-1/2 mx-1" wire:click="spp_status_save">Publish immediately</flux:button>
        </div>
    </flux:modal>
</div>