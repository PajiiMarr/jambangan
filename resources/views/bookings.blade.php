<x-layouts.app title="Bookings">
    <div class="flex flex-col gap-6 p-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">Bookings</h1>
            <!-- Placeholder for future actions (e.g. export, filters) -->
            <div class="space-x-2">
                <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                    Export
                </button>
                <button class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded hover:bg-blue-50">
                    Filter
                </button>
            </div>
        </div>

        <!-- Bookings Component -->
        <div class="flex w-full flex-1 flex-col gap-4">
            @livewire('bookings-component')
        </div>
    </div>
</x-layouts.app>
