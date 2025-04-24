<div class="w-full md:w-1/2 flex justify-end md:justify-end">
    <flux:modal.trigger name="add-performance" >
       <flux:button icon-trailing="plus" class="cursor-pointer">Add performances</flux:button>
   </flux:modal.trigger>

   <flux:modal name="add-performance" class="w-full md:w-123">
        <flux:heading size="lg">
            Add Performance
        </flux:heading>
         
        <form wire:submit.prevent="save" method="POST">
            @csrf
            <flux:field class="my-3">
                <flux:field>
                    <flux:label>Title</flux:label>
                    <flux:input wire:model.blur="title" placeholder="Enter Title" />

                    @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>Description</flux:label>
                    <flux:textarea wire:model.blur="description" placeholder="Enter Description" />

                    @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>Cover Photo</flux:label>
                    <x-inputs.filepond wire:model='uploadedFile'/>

                    {{-- @error('description') <span class="text-red-500">{{ $message }}</span> @enderror --}}
                </flux:field>
            </flux:field>
            <flux:button class="w-full" type="submit">Post</flux:button>
        </form>
   </flux:modal>
</div>
