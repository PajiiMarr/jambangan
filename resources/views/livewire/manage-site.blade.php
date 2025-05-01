@php
    $isMobile = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
    // dd($isMobile);
@endphp

<div class="flex h-full w-full flex-col">
    <div class="container mx-auto px-4 py-6">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Site Management') }}</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Configure your site settings and appearance') }}</p>
            </div>
        </div>

        <div class="mt-6 space-y-6">
            <!-- Site Identity Card -->
            <form wire:submit.prevent="saveSiteIdentity" class="bg-white dark:bg-zinc-900 shadow rounded-2xl p-6 border border-zinc-200 dark:border-zinc-700">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ __('Site Identity') }}</h2>
                    <flux:button type="submit" variant="primary" size="sm">
                        {{ __('Save Changes') }}
                    </flux:button>
                </div>
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
            </form>

            <!-- Mission and Vision -->
            <form wire:submit.prevent="saveMissionVision" class="bg-white dark:bg-zinc-900 shadow rounded-2xl p-6 border border-zinc-200 dark:border-zinc-700">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ __('Mission and Vision') }}</h2>
                    <flux:button type="submit" variant="primary" size="sm">
                        {{ __('Save Changes') }}
                    </flux:button>
                </div>
                <div class="grid gap-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Mission') }}</label>
                        <input type="text" wire:model="mission" placeholder="{{ __('Input for mission...') }}"
                            class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Vision') }}</label>
                        <input type="text" wire:model="vision" placeholder="{{ __('Input for vision...') }}"
                            class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>
            </form>

            <!-- Core Values -->
            <form wire:submit.prevent="saveCoreValue" class="bg-white dark:bg-zinc-900 shadow rounded-2xl p-6 border border-zinc-200 dark:border-zinc-700">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ __('Core Values') }}</h2>
                    <flux:button type="submit" variant="primary" size="sm">
                        {{ __('Save Changes') }}
                    </flux:button>
                </div>
                <div class="grid gap-6">
                    @forelse ($core_values as $core_value)
                        <div class="p-4 bg-zinc-100 dark:bg-zinc-800 rounded-xl relative">
                            <h3 class="text-md font-bold text-zinc-800 dark:text-zinc-100">{{ $core_value->core_value_title }}</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $core_value->core_value_description }}</p>

                            <div class="flex justify-end gap-2 mt-3">
                                {{-- Edit Button --}}
                                <flux:modal.trigger name="edit-core-value-{{ $core_value->id }}">
                                    <flux:button size="sm">Edit</flux:button>
                                </flux:modal.trigger>

                                {{-- Delete Button --}}
                                <flux:modal.trigger name="delete-core-value-{{ $core_value->id }}">
                                    <flux:button size="sm">Delete</flux:button>
                                </flux:modal.trigger>
                            </div>
                        </div>

                        {{-- Modal for editing --}}
                        <flux:modal name="edit-core-value-{{ $core_value->id }}" class="md:w-96">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Edit Core Value</flux:heading>
                                    <flux:text class="mt-2">Update the core value details.</flux:text>
                                </div>

                                <flux:input label="Title" wire:model.defer="editValues.{{ $core_value->id }}.title" />
                                <flux:input label="Description" wire:model.defer="editValues.{{ $core_value->id }}.description" />

                                <div class="flex">
                                    <flux:spacer />
                                    <flux:button type="button" variant="primary" wire:click="updateCoreValue({{ $core_value->id }})">
                                        Save Changes
                                    </flux:button>
                                </div>
                            </div>
                        </flux:modal>

                        {{-- Modal for deleting core value --}}
                        <flux:modal name="delete-core-value-{{ $core_value->id }}" class="md:w-96">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Delete Core Value</flux:heading>
                                    <flux:text class="mt-2">Are you sure you want to delete this core value?</flux:text>
                                </div>
                                <div class="flex">
                                    <flux:spacer />
                                    <flux:button 
                                        type="button" 
                                        variant="danger" 
                                        wire:click="deleteCoreValue({{ $core_value->id }})"
                                        wire:loading.attr="disabled">
                                        Delete
                                    </flux:button>
                                </div>
                            </div>
                        </flux:modal>

                    @empty
                    <div class="mb-4 border-b pb-4">
                            <p class="text-md text-zinc-500 dark:text-zinc-400">{{ __('No core values available.') }}</p>
                        </div>
                    @endforelse

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Core Value') }}</label>
                        <input type="text" wire:model="core_value_title" placeholder="{{ __('Input for core value...') }}"
                            class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Core Value Description') }}</label>
                        <input type="text" wire:model="core_value_description" placeholder="{{ __('Input for core value description...') }}"
                            class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>
            </form>

            <!-- Contact Details -->
            <form wire:submit.prevent="saveContactDetails" class="bg-white dark:bg-zinc-900 shadow rounded-2xl p-6 border border-zinc-200 dark:border-zinc-700">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ __('Contact Details') }}</h2>
                    <flux:button type="submit" variant="primary" size="sm">
                        {{ __('Save Changes') }}
                    </flux:button>
                </div>
                <div class="grid gap-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Contact Email') }}</label>
                        <input type="email" wire:model="contact_email" placeholder="admin@example.com"
                            class="my-2 w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Contact Number') }}</label>
                        <input type="contact_number" wire:model="contact_number" placeholder="09-1234-5678"
                            class="my-2 w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Address') }}</label>
                        <input type="address" wire:model="address" placeholder="Address"
                            class="my-2 w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>
            </form>

            <!-- Cover Medias -->
            <form wire:submit.prevent="saveCoverMedia" class="bg-white dark:bg-zinc-900 shadow rounded-2xl p-6 border border-zinc-200 dark:border-zinc-700">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ __('Cover Medias') }}</h2>
                    <flux:button type="submit" variant="primary" size="sm">
                        {{ __('Save Changes') }}
                    </flux:button>
                </div>
                @forelse ($cover_medias as $medias)
                <div wire:key="cover-media-{{ $medias->id }}" class="w-full flex flex-col border-b pb-3 md:flex-row gap-4 mb-4">
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
            
                        <div class="flex justify-end gap-2 mt-4">
                            {{-- Edit Button --}}
                            <flux:modal.trigger name="edit-cover-media-{{ $medias->id }}">
                                <flux:button size="sm">Edit</flux:button>
                            </flux:modal.trigger>
            
                            {{-- Delete Button --}}
                            <button wire:click="confirmDelete({{ $medias->media_id }})" 
                                    class="px-3 py-1 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="mb-4 border-b pb-4">
                        <p class="text-md text-zinc-500 dark:text-zinc-400">{{ __('No cover medias available.') }}</p>
                    </div>
                @endforelse

                {{-- Single Delete Modal --}}
                <div x-show="$wire.showDeleteModal" 
                     class="fixed inset-0 z-50 overflow-y-auto" 
                     style="display: none;">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">Delete Cover Media</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">Are you sure you want to delete this media item?</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" 
                                        wire:click="deleteCoverMedia"
                                        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Delete
                                </button>
                                <button type="button" 
                                        wire:click="$set('showDeleteModal', false)"
                                        class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Edit Modals --}}
                @foreach ($cover_medias as $medias)
                    <flux:modal name="edit-cover-media-{{ $medias->id }}" class="md:w-96">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Edit Cover Media</flux:heading>
                                <flux:text class="mt-2">Update the title and subtitle.</flux:text>

                                @if ($medias->type == 'image')
                                    <img src="http://localhost:9000/my-bucket/{{ $medias->file_data }}" alt="Cover Image" class="w-full h-48 object-cover rounded-lg mb-4">
                                @elseif ($medias->type == 'video')
                                    <video controls class="w-full h-48 object-cover rounded-lg mb-4">
                                        <source src="{{ $medias->file_data }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            </div>
                
                            <flux:input label="Title" wire:model.defer="coverEditValues.{{ $medias->id }}.title" />
                            <flux:input label="Subtitle" wire:model.defer="coverEditValues.{{ $medias->id }}.subtitle" />

                            <flux:label>Update Cover Photo</flux:label>
                            <x-inputs.filepond wire:model="file_path"/>

                            <div class="flex">
                                <flux:spacer />
                                <flux:button type="button" variant="primary" wire:click="updateCoverMedia({{ $medias->id }})">
                                    Save Changes
                                </flux:button>
                            </div>
                        </div>
                    </flux:modal>
                @endforeach
            
                <div class="grid gap-6">
                    <div class="w-full flex flex-col md:flex-row gap-4">
                        <div class="md:w-1/2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Cover Photo/Videos') }}</label>
                            <x-inputs.filepond wire:model="file_path"/>
                        </div>
        
                        <div class="md:w-1/2">
                            <flux:input label="Title" class="mb-3" wire:model="title"/>
                            <flux:input label="Sub-Title" class="mb-3" wire:model="subtitle"/>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Logo -->
            <form wire:submit.prevent="saveLogo" class="bg-white dark:bg-zinc-900 shadow rounded-2xl p-6 border border-zinc-200 dark:border-zinc-700">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ __('Logo') }}</h2>
                    <flux:button type="submit" variant="primary" size="sm">
                        {{ __('Save Changes') }}
                    </flux:button>
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
            </form>
        </div>
    </div>
</div>

{{-- Flash Messages --}}
@if (session()->has('message') || session()->has('error'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed bottom-4 right-4 z-50">
        <div class="bg-{{ session()->has('message') ? 'green' : 'red' }}-500 text-white px-4 py-2 rounded-lg shadow-lg">
            {{ session('message') ?? session('error') }}
        </div>
    </div>
@endif

{{-- Modal Close Handler --}}
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', (data) => {
            const modal = document.querySelector(`[data-modal="${data.name}"]`);
            if (modal) {
                modal.remove();
            }
        });
    });
</script>