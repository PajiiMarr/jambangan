<div 
    wire:ignore
    x-data 
    x-init ="
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.setOptions({
            allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
            acceptedFileTypes: [
                'image/jpeg', 
                'image/png', 
                'image/gif', 
                'image/webp', 
                'image/bmp', 
                'image/tiff',
                'video/mp4', 
                'video/avi', 
                'video/quicktime', 
                'video/x-ms-wmv', 
                'video/x-flv', 
                'video/webm', 
                'video/x-matroska'
            ],
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
                },
                revert: (uniqueFileId, load, error) => {
                    @this.removeUpload('{{ $attributes['wire:model'] }}', uniqueFileId, load)
                }
            }
        });
    {{-- FilePond.create($refs.input); --}}
        FilePond.create($refs.input, {
            onprocessfile: (error, file) => {
                if (!error) {
                    // Force Livewire to refresh after upload
                    @this.call('$refresh');
                }
            }
        });

    " 
>
    <input type="file" x-ref="input" />
</div>