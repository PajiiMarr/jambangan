@php
    $isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
    // dd($isMobile);
@endphp

<div class="flex h-full w-full flex-col">
    <form method="POST" wire:submit.prevent="save">
        @csrf
        <div class="container mx-auto px-4 py-6">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Site Management') }}</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Configure your site settings and appearance') }}</p>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    {{ __('Save Changes') }}
                </button>
            </div>
    
            <!-- Tab Navigation -->
            <div>
                <div class="mt-6 space-y-6">
    
                    <!-- Site Identity Card -->
                    <div class="bg-white dark:bg-zinc-900 shadow rounded-2xl p-6 border border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 mb-4">{{ __('Site Identity') }}</h2>
                        <div class="grid gap-6">
                            
                            <!-- Site Title -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Title') }}</label>
                                <input type="text" wire:model="site_title" placeholder="{{ __('Site Title') }}"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
    
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('About Us') }}</label>
                                <flux:textarea type="text" wire:model="about_us" placeholder="{{ __('About Us') }}"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </flux:textarea>
                            </div>
                
                        </div>
                    </div>
    
                
                    <!-- General Settings Card -->
                    <div class="bg-white dark:bg-zinc-900 shadow rounded-2xl p-6 border border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 mb-4">{{ __('Contact Details') }}</h2>
                        <div class="grid gap-6">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Contact Email') }}</label>
                                <input type="email" wire:model="contact_email" placeholder="admin@example.com"
                                    class="my-2 w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Contact Number') }}</label>
                                <input type="contact_number" wire:model="contact_number" placeholder="09-1234-5678"
                                    class="my-2 w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                
                                {{-- <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Social Links') }}</label>
                                <input type="contact_number" wire:model="" placeholder="admin@example.com"
                                    class="my-2 w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" /> --}}
                            </div>
                        </div>
                    </div>
                
                </div>
                
                <div class="mt-6 space-y-6">
    
                    <div class="bg-white dark:bg-zinc-900 shadow rounded-2xl p-6 border border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 mb-4">{{ __('Cover Medias') }}</h2>
{{-- 
                        <flux:modal.trigger name="add-cover">
                        <flux:button>Edit profile</flux:button>
                    </flux:modal.trigger>

                    <flux:modal name="add-cover" class="w-full md:w-123" :variant="$isMobile ? 'flyout' : null"
                    :position="$isMobile ? 'bottom' : null">
                        <div class="grid gap-6">
                            <div class="w-full flex flex-col md:flex-row gap-4">
                                <div class="md:w-1/2">
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Cover Photo/Videos') }}</label>
                                    <x-inputs.filepond wire:model="file_path"/>
                                </div>
    
                                <div class="md:w-1/2">
                                    <flux:input label="Title" class="mb-3"  wire:model="title"/>
                                    <flux:input label="Sub-Title" class="mb-3" wire:model="subtitle"/>
                                </div>
    
                            </div>                        
                        </div>
                    </flux:modal> --}}
                        @forelse ($cover_medias as $medias)
                            <div wire:key="cover-media-{{ $medias->id }}" class='w-full flex flex-col border-b pb-3 md:flex-row gap-4 mb-4'>
                                <div class="w-1/2">
                                    @if ($medias->type == 'image')
                                        <img src="http://localhost:9000/my-bucket/{{ $medias->file_data }}" alt="Cover Image" class="w-full h-48 object-cover rounded-lg mb-4">
                                    @elseif ($medias->type == 'video')
                                        <video controls class="w-full h-48 object-cover rounded-lg mb-4">
                                            <source src="{{ $medias->file_data }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </div>
                                
                                <div class="w-1/2 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 mb-2">{{ $medias->title }}</h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $medias->subtitle }}</p>
                                    </div>
                                    <button class="mt-4 text-red-600 hover:text-red-800">
                                        <i class="fa fa-trash"></i> {{ __('Delete') }}
                                    </button>
    
                                </div>
                            </div>
                            
                        @empty
                            <div class="mb-4 border-b pb-4">
                                <p class="text-md text-zinc-500 dark:text-zinc-400">{{ __('No cover medias available.') }}</p>
                            </div>
                        @endforelse
                        <div class="grid gap-6">
                            <div class="w-full flex flex-col md:flex-row gap-4">
                                <div class="md:w-1/2">
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Cover Photo/Videos') }}</label>
                                    <x-inputs.filepond wire:model="file_path"/>
                                </div>
    
                                <div class="md:w-1/2">
                                    <flux:input label="Title" class="mb-3"  wire:model="title"/>
                                    <flux:input label="Sub-Title" class="mb-3" wire:model="subtitle"/>
                                </div>
    
                            </div>                        
                        </div>

                        <div class="grid gap-6">
                            <div class="w-full flex flex-col md:flex-row gap-4">
                                <div class="md:w-1/2">
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Input Logo') }}</label>
                                    <x-inputs.filepond wire:model="logo_path"/>
                                </div>

                                <div class="md:w-1/2">
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Logo Preview') }}</label>
                                    <img src="{{ $general_contents && $general_contents->logo_path ? $general_contents->logo_path : asset('images/LogoColored.png') }}" alt="Logo" class="w-full h-48 object-cover rounded-lg mb-4">
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>