<x-layouts.app title="Posts">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="sm:w-full md:flex md:align-middle md:justify-center">
            @livewire('upload-media')
        </div>
        <div class="flex justify-center">
            <div class="w-full md:w-3/4 lg:w-1/2">
                @livewire('post-list')
            </div>
        </div>
    </div>
</x-layouts.app>
