<x-layouts.app title="Events">
    <h1 class="text-2xl font-bold">Events</h1>
    <div class="mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <p class="text-black dark:text-white mt-1">Manage and organize your events</p>
            </div>
        </div>
    </div>
    @livewire('calendar')
</x-layouts.app>