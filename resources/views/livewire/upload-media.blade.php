<div class="h-25 w-full md:w-150 rounded-xl border-neutral-200">
    <flux:modal.trigger name="create-post" class="w-full h-full flex rounded-xl p-1.5 cursor-pointer border-2 border-neutral-200 dark:hover:bg-gray-600 hover:bg-gray-100 duration-100 ease-in-out">
        Write a post...
    </flux:modal.trigger>

        <flux:modal name="create-post" class="w-full md:w-123">
        <div class="text-center space-x-3">
            <flux:heading size="lg">
                Create Post
            </flux:heading>
        </div>
        <form wire:submit.prevent="save" method="POST">
            @csrf
            <flux:field class="my-3">
                <flux:field>
                    <flux:label>Title</flux:label>
                    <flux:input wire:model.blur="title" placeholder="Enter Title" />

                    @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>Content</flux:label>
                    <textarea class="resize-none p-2 border border-neutral-200 rounded-md w-full" wire:model="content" placeholder="Enter content..."></textarea>
                </flux:field>
                <div class="flex w-full justify-between ">
                    <flux:dropdown class="me-2">
                        <flux:label>Events</flux:label><br>
                        <flux:button icon-trailing="chevron-down" class="mt-1">
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

                    <flux:dropdown class="me-2 w-[48%]   ">
                        <flux:label>Performance</flux:label><br>
                        <flux:button icon-trailing="chevron-down" class="mt-1">
                            {{ $selectedPerformanceName }}
                        </flux:button>
                        <flux:menu>
                            <flux:menu.radio.group wire:model.live="selectedPerformance">
                                @foreach($performances as $performance)
                                    <flux:menu.radio value="{{ $performance->performance_id }}">
                                        {{ $performance->title }}
                                    </flux:menu.radio>
                                @endforeach
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>
                </div>

                <x-inputs.filepond wire:model='uploadedFiles' multiple />
                @error('content') <span class="text-red-500">{{ $message }}</span> @enderror

            </flux:field>
            <flux:button class="w-full" type="submit">Post</flux:button>
        </form>
    </flux:modal>
</div>
