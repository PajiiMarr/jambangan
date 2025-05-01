<x-layouts.app title="Posts">
    <h1 class="text-2xl font-bold">Posts</h1>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="w-full">
            @livewire('upload-media')
        </div>
        <div class="flex justify-center w-full">
            <div class="w-full">
                @livewire('post-list')
            </div>
        </div>
    </div>
</x-layouts.app>
