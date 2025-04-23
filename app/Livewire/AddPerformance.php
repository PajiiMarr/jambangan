<?php

namespace App\Livewire;

use App\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use App\Models\Performances;
use Illuminate\Http\Request;

class AddPerformance extends Component
{
    use WithFileUploads;

    #[Validate([
        'title' => "required|string|max:255",
    ])]
    public $title;

    #[Validate([
        'description' => "required|string|max:255",
    ])]
    public $description;


    #[Validate([
        'uploadedFile.*' => [
            'file',
            'mimes:jpg,jpeg,png,',
            'max:51200'
        ]
    ])]
    public $uploadedFile;
    public $temporaryUploadedFile;

    public function mount() {
        $this->title = '';
        $this->description = '';
    }

    public function fileUploaded($data)
    {
        if (isset($data['filename'])) {
            $tempPath = 'livewire-tmp/' . $data['filename'];

            if (Storage::disk('local')->exists($tempPath)) {
                $file = new \Illuminate\Http\UploadedFile(
                    Storage::disk('local')->path($tempPath),
                    $data['filename']
                );

                $validator = validator()->make(
                    ['file' => $file],
                    [
                        'file' => [
                            'required',
                            'file',
                            'mimes:jpg, jpeg, png, gif, webp, bmp, tiff',
                            'max:51200'
                        ]
                    ],
                    $this->messages
                );

                if ($validator->fails()) {
                    $this->addError('uploadedFile', $validator->errors()->first('file'));
                } else {
                    $this->temporaryUploadedFile = $data['filename'];
                }
            }
        }
    }

    private function getMediaType($extension)
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'tiff'];
//        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];

        if (in_array($extension, $imageExtensions)) {
            return 'image';
        }

        return 'unknown'; // Fallback, although ideally should never be used
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // 1. Create Performance
            $performance = Performances::create([
                'title' => $this->title,
                'description' => $this->description,
            ]);

            // 2. Attach Media (One-to-One)
            if ($this->uploadedFile) {
                $file = $this->uploadedFile;
                $path = $file->store('uploads', 's3');

                Media::create([
                    'performance_id' => $performance->performance_id, // Link to the performance
                    'file_data' => $path,
                    'type' => $this->getMediaType($file->extension()),
                    'uploaded_at' => now(),
                ]);
            }

            DB::commit();
            $this->reset(['title', 'description', 'uploadedFile']);
            $this->modal('add-performance')->close();
            $this->dispatch('performance-added', performance: $performance);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving performance: ' . $e->getMessage());
            $this->addError('save', 'Failed to save performance: ' . $e->getMessage());
        }
    }
    

    public function render()
    {
        return view('livewire.add-performance');
    }
}
