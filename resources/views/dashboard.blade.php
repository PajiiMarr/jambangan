<x-layouts.app title="Dashboard">
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @foreach ($mockDashboardData as $key => $data)
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 bg-white dark:bg-zinc-900 shadow-md flex flex-col justify-between">
                    <!-- Background Decorative Element -->
                    <div class="absolute inset-0 opacity-10 bg-cover bg-center" style="background-image: url('/images/dashboard-pattern.svg');"></div>

                    <div class="relative z-10 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-neutral-700 dark:text-neutral-200">
                            @if ($key == "performances_count")
                                Total Performances
                            @elseif ($key == "posts_count")
                                Total Posts
                            @else
                                Total Events
                            @endif   
                        </h2>
                        <flux:icon name="{{ $data['icon'] }}" class="w-10 h-10 text-blue-500 dark:text-blue-400" />
                    </div>

                    <!-- Centered Statistic -->
                    <div class="relative z-10 flex-1 flex flex-col justify-center">
                        <p class="text-6xl font-extrabold text-neutral-900 dark:text-white tracking-tight">
                            {{ number_format($data['count']) }}
                        </p>
                        <p class="text-md text-neutral-500 dark:text-neutral-400">
                            {{ __('Total this month') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Live Chart -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 shadow-md p-6">
        <livewire:live-chart/>
        </div>
    </div>
</x-layouts.app>
