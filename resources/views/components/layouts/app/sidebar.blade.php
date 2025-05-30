<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group  class="grid">
                    <flux:navlist.item icon="home-icon" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group class="grid">
                    <flux:navlist.item icon="sparkle" :href="route('performances')" :current="request()->routeIs('performances')" wire:navigate>{{ __('Performances') }}</flux:navlist.item>
                </flux:navlist.group>
                
                <flux:navlist.group class="grid">
                    <flux:navlist.item icon="event-calendar" :href="route('events')" :current="request()->routeIs('events')" wire:navigate>{{ __('Events') }}</flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group class="grid">
                    <flux:navlist.item icon="paper" :href="route('posts')" :current="request()->routeIs('posts')" wire:navigate>{{ __('Posts') }}</flux:navlist.item>
                </flux:navlist.group>


                <flux:navlist.group class="grid">
                    <flux:navlist.item icon="manage" :href="route('manage')" :current="request()->routeIs('manage')" wire:navigate>{{ __('Manage Site') }}</flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group class="grid">
                    <flux:navlist.item icon="officers" :href="route('officers')" :current="request()->routeIs('officers')" wire:navigate>{{ __('Officers') }}</flux:navlist.item>
                </flux:navlist.group>
                
                <flux:navlist.group class="grid">
                    <flux:navlist.item icon="bookings" :href="route('bookings')" :current="request()->routeIs('bookings')" wire:navigate>{{ __('Bookings') }}</flux:navlist.item>
                </flux:navlist.group>
                
                @if(auth()->check() && auth()->user()->is_superadmin)
                <flux:navlist.group class="grid">
                    <flux:navlist.item icon="admin-users" :href="route('admin-users')" :current="request()->routeIs('admin-users')" wire:navigate>{{ __('Users') }}</flux:navlist.item>
                </flux:navlist.group>
                @endif

                <flux:navlist.group class="grid">
                    <flux:navlist.item icon="logs" :href="route('logs')" :current="request()->routeIs('logs')" wire:navigate>{{ __('Logs') }}</flux:navlist.item>
                </flux:navlist.group>

            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
        <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    </body>
</html>
