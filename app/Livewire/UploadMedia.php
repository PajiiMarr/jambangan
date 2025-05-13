<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Events;
use App\Models\Posts;
use App\Models\Media;
use App\Models\Performances;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use App\Models\Logs;

class UploadMedia extends Component
{
    use WithFileUploads;

    #[Validate([
        'content' => 'nullable|string|max:255',
    ])]
    public $content;

    #[Validate([
        'title' => 'required|string|max:255',
    ])]
    public $title;

    #[Validate([
        'uploadedFiles.*' => [
            'file',
            'mimes:jpg,jpeg,png,gif,webp,bmp,tiff,mp4,avi,mov,wmv,flv,webm,mkv',
            'max:51200'
        ]
    ])]
    public $uploadedFiles = [];

    public $temporaryUploadedFiles = [];

    public $events;
    public $performances;

    // #[Reactive]
    public $selectedEventName = 'Select Event';
    public $selectedPerformanceName = 'Select Performance';

    // Add filter properties
    public $eventFilter = '';
    public $performanceFilter = '';

    protected $messages = [
        'title.required' => 'Please enter a title for your post.',
        'title.max' => 'The title cannot be longer than 255 characters.',
        'content.max' => 'The content cannot be longer than 255 characters.',
        'uploadedFiles.*.file' => 'The uploaded item must be a valid file.',
        'uploadedFiles.*.mimes' => 'Only image and video files (jpg, jpeg, png, gif, webp, bmp, tiff, mp4, avi, mov, wmv, flv, webm, mkv) are allowed.',
        'uploadedFiles.*.max' => 'Each file must be smaller than 50 MB.'
    ];

    public $selectedEvent = null;
    public $selectedPerformance = null;

    public function rules()
    {
        return [
            'uploadedFiles.*' => [
                'file',
                'mimes:jpg,jpeg,png,gif,webp,bmp,tiff,mp4,avi,mov,wmv,flv,webm,mkv',
                function($attribute, $value, $fail) {
                    $allowedMimes = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'tiff', 'mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];
                    $extension = strtolower($value->getClientOriginalExtension());

                    if (!in_array($extension, $allowedMimes)) {
                        $fail("The file type $extension is not allowed.");
                    }
                },
                'max:51200'
            ]
        ];
    }

    public function updatedSelectedEvent($value)
    {
        if ($value == "none"){
            $this->selectedEventName = "None";
            $this->selectedEvent = null;
            return;
        }

        if ($value) {
            $event = Events::find($value);
            $this->selectedEventName = $event ? $event->event_name : 'Select Event';
        } else {
            $this->selectedEventName = 'Select Event';
        }
    }

    public function updatedSelectedPerformance($value)
    {
        if ($value == "none"){
            $this->selectedPerformanceName = "None";
            $this->selectedPerformance = null;
            return;
        }

        if ($value) {
            $performance = Performances::find($value);
            $this->selectedPerformanceName = $performance ? $performance->title : 'Select Performance';
        } else {
            $this->selectedPerformanceName = 'Select Performance';
        }
    }

    public function mount() {
        $this->events = Events::orderBy('start_date', 'asc')->get();
        $this->performances = Performances::orderBy('created_at', 'asc')->get();
    }

    // Add filter methods
    public function updatedEventFilter($value)
    {
        $this->selectedEvent = $value;
        $this->updatedSelectedEvent($value);
    }

    public function updatedPerformanceFilter($value)
    {
        $this->selectedPerformance = $value;
        $this->updatedSelectedPerformance($value);
    }

    #[On('file-uploaded')]
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
                            'mimes:jpg,jpeg,png,gif,webp,bmp,tiff,mp4,avi,mov,wmv,flv,webm,mkv',
                            'max:51200'
                        ]
                    ],
                    $this->messages
                );

                if ($validator->fails()) {
                    $this->addError('uploadedFiles', $validator->errors()->first('file'));
                } else {
                    $this->temporaryUploadedFiles[] = $data['filename'];
                }
            }
        }
    }
    
    private function getMediaType($extension)
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'tiff'];
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];

        if (in_array($extension, $imageExtensions)) {
            return 'image';
        }

        if (in_array($extension, $videoExtensions)) {
            return 'video';
        }

        return 'unknown'; // Fallback, although ideally should never be used
    }


    public function save()
    {
        Log::debug('Starting save process');
        Log::debug('Title: ' . $this->title);
        Log::debug('Content: ' . $this->content);
        Log::debug('Selected Event: ' . print_r($this->selectedEvent, true));
        Log::debug('Selected Performance: ' . print_r($this->selectedEvent, true));

        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $post = Posts::create([
                'title' => $this->title,
                'content' => $this->content,
                'user_id' => Auth::id(),
                'event_id' => $this->selectedEvent,
                'performance_id' => $this->selectedPerformance,
            ]);

            if (!empty($this->uploadedFiles)) {
                foreach ($this->uploadedFiles as $file) {
                    if (is_object($file) && method_exists($file, 'store')) {
                        $path = $file->store(
                            'uploads', // Your desired folder in S3
                            's3' // The disk name configured in config/filesystems.php
                        );

                        // Get the full public URL
                        $url = Storage::url($path);
                        $mediaType = $this->getMediaType($file->extension());

                        Media::create([
                            'post_id' => $post->post_id,
                            'file_data' => $path,
                            'type' => $mediaType,
                        ]);
                    }
                }
                Log::debug('File processed: ' . $path);
            }

            DB::commit();

            Logs::create([
                'action' => 'Created a post',
                'navigation' => 'posts',
                'user_id' => Auth::id(),
                'post_id' => $post->post_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::debug('Post created with ID: ' . $post->id);

            $this->reset(['title', 'content', 'selectedEvent', 'uploadedFiles', 'temporaryUploadedFiles']);

            $this->modal('create-post')->close();
            $this->dispatch('postUploaded');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Post creation failed: ' . $e->getMessage());
            $this->addError('save', 'Failed to create post: ' . $e->getMessage());
        }
    }

    public function validateFiles()
    {
        $validator = validator()->make(
            ['uploadedFiles' => $this->temporaryUploadedFiles],
            [
                'uploadedFiles.*' => [
                    'required',
                    'file',
                    'mimes:jpg,jpeg,png,gif,webp,bmp,tiff,mp4,avi,mov,wmv,flv,webm,mkv',
                    'max:51200'
                ]
            ],
            $this->messages
        );

        if ($validator->fails()) {
            $this->addError('uploadedFiles', $validator->errors()->first());
        }
    }

    public function render()
    {
        return view('livewire.upload-media', [
            'events' => $this->events,
            'performances' => $this->performances,
        ]);
    }
}
