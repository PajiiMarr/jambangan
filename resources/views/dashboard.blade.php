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
                            {{ __($key === 'page_views' ? 'Page Views' : ($key === 'posts_uploaded' ? 'Posts Uploaded' : 'Events Created')) }}
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

                    <!-- Footer Details -->
                    <div class="relative z-10 flex justify-between items-center text-sm font-medium">
                        <span class="text-gray-500 dark:text-gray-400">
                            {{ __('Last updated: ') }} {{ now()->format('M d, Y') }}
                        </span>
                        <span class="flex items-center">
                            {{-- <flux:icon name="{{ $data['trend'][0] }}" class="w-5 h-5 mr-1" /> --}}
                            {{ $data['trend'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Live Chart -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 shadow-md p-6">
            <div wire:ignore.self x-data="chartComponent({{ json_encode($chartData) }})" class="w-full h-150 sm-h-full">
                <div class="flex gap-4 ms-4 mt-3">
                    <select class="p-2 rounded" x-model="selectedYear" @change="updateChart">
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                    <select class="p-2 rounded" x-model="selectedMonth" @change="updateChart">
                        @foreach ($months as $month)
                            <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                {{ \Carbon\Carbon::createFromFormat('m', str_pad($month, 2, '0', STR_PAD_LEFT))->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Chart Canvas -->
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</x-layouts.app>
