<div class="h-25 md:w-150 rounded-xl border-neutral-200">
    <flux:modal.trigger name="create-post" class="w-full h-full flex rounded-xl p-1.5 cursor-pointer border-2 border-neutral-200 dark:hover:bg-gray-600 hover:bg-gray-100 duration-100 ease-in-out">
        Write a post...
    </flux:modal.trigger>

        <flux:modal name="create-post" class="w-full sm:w-full md:w-123">
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

                <flux:dropdown >

                    <flux:label>Events</flux:label><br>
                    <flux:button icon="chevron-down" class="mt-1 ">
                            Select Events
                    </flux:button>

                    <flux:menu >
                        @foreach($events as $event)
                            <flux:menu.checkbox
                                wire:model.blur="selectedEvent"
                                value="{{ $event->event_id }}"

                            >
                                {{ $event->event_name }} {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}
                            </flux:menu.checkbox>
                        @endforeach
                    </flux:menu>
                </flux:dropdown>

                <x-inputs.filepond wire:model='uploadedFiles' multiple />
                @error('content') <span class="text-red-500">{{ $message }}</span> @enderror

            </flux:field>
            <flux:button class="w-full" type="submit">Post</flux:button>
        </form>
    </flux:modal>
</div>
