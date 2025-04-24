<x-layouts.app title="Contents">
    <div class="text-2xl font-bold mb-2">
        <h2>Manage Contents</h2>
    </div>
    <div class="flex flex-col h-full w-full flex-1 gap-4 md:flex-row">
        <div class=" w-full md:w-[48%] md:h-[100vh] flex flex-col">
            <div class="w-full m-2 md:flex md:align-middle md:justify-center">
                @livewire('upload-media')
            </div>
            <div class="flex m-2 justify-center">
                <div class="w-full md:w-120">
                    @livewire('post-list')
                </div>
            </div>
        </div>
        <div class="w-full md:w-[48%] h-full">
            <div class="relative h-full flex-1 overflow-hidden rounded-xl">
                @livewire('calendar')
            </div>
        </div>
    </div>
</x-layouts.app>
