<x-layouts.app title="Posts">
    <h1 class="text-2xl font-bold">Posts</h1>
    <div class="mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <p class="text-black dark:text-white mt-1">Manage and organize your posts</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <flux:modal.trigger name="create-post">
                    <flux:button variant="primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                        Add New Post
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>
    </div>
    <div class="flex h-full w-full flex-1 flex-col rounded-xl">
        <div class="w-full">
            @livewire('upload-media')
        </div>
        <div class="flex justify-center w-full  ">
            <div class="w-full ">
                @livewire('post-list')
            </div>
        </div>
    </div>
</x-layouts.app>
