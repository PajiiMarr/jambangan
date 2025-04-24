<div class="flex h-full w-full flex-col">
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Site Management') }}</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Configure your site settings and appearance') }}</p>
            </div>
            <flux:button variant="primary" icon="check">
                {{ __('Save Changes') }}
            </flux:button>
        </div>

        <!-- Tab Navigation -->
        <div x-data="{ currentTab: 'general' }">
            <div class="flex space-x-4 border-b border-zinc-200 dark:border-zinc-700">
                <button
                    class="py-2 px-4 text-sm font-medium border-b-2"
                    :class="$wire.tab === 'general' ? 'border-accent text-accent' : 'border-transparent text-zinc-500 hover:text-accent'"
                    wire:click="$set('tab', 'general')">
                    <i class="fa fa-cog mr-1"></i> {{ __('General') }}
                </button>
                <button
                    class="py-2 px-4 text-sm font-medium border-b-2"
                    :class="$wire.tab === 'theme' ? 'border-accent text-accent' : 'border-transparent text-zinc-500 hover:text-accent'"
                    wire:click="$set('tab', 'theme')">
                    <i class="fa fa-paint-brush mr-1"></i> {{ __('Theme') }}
                </button>
                <button
                    class="py-2 px-4 text-sm font-medium border-b-2"
                    :class="$wire.tab === 'menus' ? 'border-accent text-accent' : 'border-transparent text-zinc-500 hover:text-accent'"
                    wire:click="$set('tab', 'menus')">
                    <i class="fa fa-bars mr-1"></i> {{ __('Menus') }}
                </button>
            </div>
            

            <!-- General Settings -->
            <div x-show="$wire.tab === 'general'" class="mt-6 space-y-6">

                <!-- Site Identity Card -->
                <div class="bg-white dark:bg-zinc-900 shadow rounded-2xl p-6 border border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 mb-4">{{ __('Site Identity') }}</h2>
                    <div class="grid gap-6">
                        
                        <!-- Site Title -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Site Title') }}</label>
                            <input type="text" wire:model="siteTitle" placeholder="{{ __('My Awesome Site') }}"
                                class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
            
                        <!-- Tagline -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Tagline') }}</label>
                            <input type="text" wire:model="siteTagline" placeholder="{{ __('A short description of your site') }}"
                                class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
            
                        <!-- Site Logo -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Site Logo') }}</label>
                            <div class="flex items-center gap-4">
                                <div class="h-16 w-16 overflow-hidden rounded-lg bg-zinc-100 dark:bg-zinc-800">
                                    {{-- @if($siteLogo)
                                        <img src="{{ $siteLogo }}" alt="Site Logo" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <svg class="h-8 w-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5h2l.4 2M7 13h10l1.4-6H6.6M7 13l1 5h8l1-5M7 13H5m14 0h2M10 21h4"/>
                                            </svg>
                                        </div>
                                    @endif --}}
                                </div>
                                <div class="flex gap-2">
                                    <button class="px-3 py-1 rounded-lg border border-zinc-300 dark:border-zinc-600 text-sm text-zinc-700 dark:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                        {{ __('Change') }}
                                    </button>
                                    <button class="px-3 py-1 rounded-lg border border-red-300 text-sm text-red-600 hover:bg-red-100 dark:border-red-600 dark:hover:bg-red-800">
                                        {{ __('Remove') }}
                                    </button>
                                </div>
                            </div>
                        </div>
            
                    </div>
                </div>
            
                <!-- General Settings Card -->
                <div class="bg-white dark:bg-zinc-900 shadow rounded-2xl p-6 border border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 mb-4">{{ __('General Settings') }}</h2>
                    <div class="grid gap-6">
                        
                        <!-- Admin Email -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Administrator Email') }}</label>
                            <input type="email" wire:model="adminEmail" placeholder="admin@example.com"
                                class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
            
                        <!-- Timezone -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Timezone') }}</label>
                            <select wire:model="timezone"
                                class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">{{ __('Select a timezone') }}</option>
                                <option value="UTC+00:00">{{ __('(UTC+00:00) London') }}</option>
                                <option value="UTC+01:00">{{ __('(UTC+01:00) Paris') }}</option>
                                <option value="UTC-05:00">{{ __('(UTC-05:00) New York') }}</option>
                            </select>
                        </div>
            
                        <!-- Date Format -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Date Format') }}</label>
                            <select wire:model="dateFormat"
                                class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="F j, Y">{{ __('F j, Y') }}</option>
                                <option value="Y-m-d">{{ __('Y-m-d') }}</option>
                                <option value="m/d/Y">{{ __('m/d/Y') }}</option>
                                <option value="d/m/Y">{{ __('d/m/Y') }}</option>
                            </select>
                        </div>
            
                    </div>
                </div>
            
            </div>
            
            
            <!-- Theme Settings -->
            <div x-show="$wire.tab === 'theme'" class="mt-6 space-y-6">
                <!-- Theme Selection -->
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('Theme Selection') }}</h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Theme Option 1 -->
                        <div class="relative">
                            <input type="radio" id="theme-default" name="theme" value="default" wire:model="selectedTheme" class="peer absolute h-0 w-0 opacity-0" />
                            <label for="theme-default" class="block cursor-pointer overflow-hidden rounded-lg border border-zinc-200 shadow-sm hover:border-accent peer-checked:border-2 peer-checked:border-accent dark:border-zinc-700">
                                <div class="h-40 bg-gradient-to-br from-blue-50 to-white dark:from-zinc-800 dark:to-zinc-900"></div>
                                <div class="p-4">
                                    <h4 class="font-medium text-zinc-900 dark:text-white">{{ __('Default') }}</h4>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Clean, modern design with blue accents') }}</p>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Theme Option 2 -->
                        <div class="relative">
                            <input type="radio" id="theme-dark" name="theme" value="dark" wire:model="selectedTheme" class="peer absolute h-0 w-0 opacity-0" />
                            <label for="theme-dark" class="block cursor-pointer overflow-hidden rounded-lg border border-zinc-200 shadow-sm hover:border-accent peer-checked:border-2 peer-checked:border-accent dark:border-zinc-700">
                                <div class="h-40 bg-gradient-to-br from-zinc-900 to-zinc-800"></div>
                                <div class="p-4">
                                    <h4 class="font-medium text-zinc-900 dark:text-white">{{ __('Dark') }}</h4>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Dark mode optimized theme') }}</p>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Theme Option 3 -->
                        <div class="relative">
                            <input type="radio" id="theme-minimal" name="theme" value="minimal" wire:model="selectedTheme" class="peer absolute h-0 w-0 opacity-0" />
                            <label for="theme-minimal" class="block cursor-pointer overflow-hidden rounded-lg border border-zinc-200 shadow-sm hover:border-accent peer-checked:border-2 peer-checked:border-accent dark:border-zinc-700">
                                <div class="h-40 bg-gradient-to-br from-white to-zinc-50 dark:from-zinc-900 dark:to-zinc-800"></div>
                                <div class="p-4">
                                    <h4 class="font-medium text-zinc-900 dark:text-white">{{ __('Minimal') }}</h4>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Simple and distraction-free') }}</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            
                <!-- Color Scheme -->
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('Color Scheme') }}</h2>
                    <div class="space-y-6">
                        <!-- Primary Color Selection -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Primary Color') }}</label>
                            <div class="flex flex-wrap gap-3">
                                <div class="flex items-center">
                                    <input type="radio" id="color-blue" name="primaryColor" value="blue" wire:model="primaryColor" class="peer h-0 w-0 opacity-0" />
                                    <label for="color-blue" class="block h-8 w-8 cursor-pointer rounded-full bg-blue-600 peer-checked:ring-2 peer-checked:ring-accent peer-checked:ring-offset-2"></label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="color-emerald" name="primaryColor" value="emerald" wire:model="primaryColor" class="peer h-0 w-0 opacity-0" />
                                    <label for="color-emerald" class="block h-8 w-8 cursor-pointer rounded-full bg-emerald-600 peer-checked:ring-2 peer-checked:ring-accent peer-checked:ring-offset-2"></label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="color-violet" name="primaryColor" value="violet" wire:model="primaryColor" class="peer h-0 w-0 opacity-0" />
                                    <label for="color-violet" class="block h-8 w-8 cursor-pointer rounded-full bg-violet-600 peer-checked:ring-2 peer-checked:ring-accent peer-checked:ring-offset-2"></label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="color-rose" name="primaryColor" value="rose" wire:model="primaryColor" class="peer h-0 w-0 opacity-0" />
                                    <label for="color-rose" class="block h-8 w-8 cursor-pointer rounded-full bg-rose-600 peer-checked:ring-2 peer-checked:ring-accent peer-checked:ring-offset-2"></label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="color-amber" name="primaryColor" value="amber" wire:model="primaryColor" class="peer h-0 w-0 opacity-0" />
                                    <label for="color-amber" class="block h-8 w-8 cursor-pointer rounded-full bg-amber-600 peer-checked:ring-2 peer-checked:ring-accent peer-checked:ring-offset-2"></label>
                                </div>
                            </div>
                        </div>
            
                        <!-- Dark Mode Toggle -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Dark Mode') }}</label>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Enable dark color scheme') }}</p>
                            <div class="flex items-center justify-between">
                                <label class="relative inline-flex cursor-pointer items-center">
                                    <input type="checkbox" wire:model="darkMode" class="peer sr-only">
                                    <div class="peer h-6 w-11 rounded-full bg-zinc-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-zinc-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-accent peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent peer-focus:ring-offset-2 dark:border-zinc-600 dark:bg-zinc-700"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <!-- Menu Settings -->
            <div x-show="$wire.tab === 'menus'" class="mt-6 space-y-6">
                <!-- Color Scheme Card -->
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">{{ __('Color Scheme Selection') }}</h2>
                    <div class="space-y-6">
                        <!-- Primary Color Selection -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Primary Color') }}</label>
                            <div class="flex flex-wrap gap-3">
                                <div class="flex items-center">
                                    <input type="radio" id="color-blue" name="primaryColor" value="blue" wire:model="primaryColor" class="peer h-0 w-0 opacity-0" />
                                    <label for="color-blue" class="block h-8 w-8 cursor-pointer rounded-full bg-blue-600 peer-checked:ring-2 peer-checked:ring-accent peer-checked:ring-offset-2"></label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="color-emerald" name="primaryColor" value="emerald" wire:model="primaryColor" class="peer h-0 w-0 opacity-0" />
                                    <label for="color-emerald" class="block h-8 w-8 cursor-pointer rounded-full bg-emerald-600 peer-checked:ring-2 peer-checked:ring-accent peer-checked:ring-offset-2"></label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="color-violet" name="primaryColor" value="violet" wire:model="primaryColor" class="peer h-0 w-0 opacity-0" />
                                    <label for="color-violet" class="block h-8 w-8 cursor-pointer rounded-full bg-violet-600 peer-checked:ring-2 peer-checked:ring-accent peer-checked:ring-offset-2"></label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="color-rose" name="primaryColor" value="rose" wire:model="primaryColor" class="peer h-0 w-0 opacity-0" />
                                    <label for="color-rose" class="block h-8 w-8 cursor-pointer rounded-full bg-rose-600 peer-checked:ring-2 peer-checked:ring-accent peer-checked:ring-offset-2"></label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="color-amber" name="primaryColor" value="amber" wire:model="primaryColor" class="peer h-0 w-0 opacity-0" />
                                    <label for="color-amber" class="block h-8 w-8 cursor-pointer rounded-full bg-amber-600 peer-checked:ring-2 peer-checked:ring-accent peer-checked:ring-offset-2"></label>
                                </div>
                            </div>
                        </div>
            
                        <!-- Dark Mode Toggle -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Dark Mode') }}</label>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Enable dark color scheme') }}</p>
                            <div class="flex items-center justify-between">
                                <label class="relative inline-flex cursor-pointer items-center">
                                    <input type="checkbox" wire:model="darkMode" class="peer sr-only">
                                    <div class="peer h-6 w-11 rounded-full bg-zinc-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-zinc-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-accent peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent peer-focus:ring-offset-2 dark:border-zinc-600 dark:bg-zinc-700"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>