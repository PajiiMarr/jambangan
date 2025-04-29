<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\General;
use App\Models\Slides;
use App\Models\Media;

class ManageSite extends Component
{
    use WithFileUploads;

    protected $listeners = ['postUploaded' => '$refresh'];

    #[Validate([
        'site_title' => 'required|string|max:255',
        'about_us' => 'required|string|max:255',
        'contact_email' => 'required|email|max:255',
        'contact_number' => 'required|string|max:15',
        'logo_path' => 'nullable|image|max:1024', // 1MB Max
        'title' => 'nullable|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv|max:10240',
    ])]
    
    public $general_contents;


    public $site_title;
    public $about_us;
    public $contact_email;
    public $contact_number;
    public $logo_path;

    public $title;
    public $subtitle;
    public $file_path;


    public $cover_medias = [];

    public function mount()
    {
        $this->generalContents();
        $this->coverMedias();

        // Log::debug('djfhgjadhfkj' . $this->cover_medias);

        if($this->general_contents){
            $this->site_title = $this->general_contents->site_title;
            $this->about_us = $this->general_contents->about_us;
            $this->contact_email = $this->general_contents->contact_email;
            $this->contact_number = $this->general_contents->contact_number;
        }
    }

    public function coverMedias (){
        $this->cover_medias = Slides::select('slides.*', 'media.*')
            ->join('media', 'slides.slide_id', '=', 'media.slide_id')
            ->get();
        // dd($this->cover_medias);
    }

    public function generalContents(){
        $this->general_contents = General::latest()->first();
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
        Log::debug('Starting manage-site save process');
        Log::debug('Site Title: ' . $this->site_title);
        Log::debug('About Us: ' . $this->about_us);
        Log::debug('Contact Email: ' . $this->contact_email);
        Log::debug('Contact Number: ' . $this->contact_number);
        Log::debug('File Path: ' . $this->file_path);

        Log::debug('Cover Title: ' . $this->title);
        Log::debug('Cover Sub-title: ' . $this->subtitle);
        try {
            DB::beginTransaction();
    
            // Save general settings
            $general = General::updateOrCreate(
                ['id' => $this->general_contents->id ?? null],
                [
                    'site_title' => $this->site_title,
                    'about_us' => $this->about_us,
                    'contact_email' => $this->contact_email,
                    'contact_number' => $this->contact_number,
                ]
            );
    
            // Only create new slide if we have file data
            if (!empty($this->file_path)) {
                $slides = Slides::create([
                    'title' => $this->title,
                    'subtitle' => $this->subtitle,
                ]);
                
                if (!$slides) {
                    throw new \Exception('Failed to create slide');
                }
    
                if (is_object($this->file_path) && method_exists($this->file_path, 'store')) {
                    $path = $this->file_path->store('uploads', 's3');
                    $url = Storage::url($path);
    
                    Media::create([
                        'slide_id' => $slides['slide_id'],
                        'file_data' => $path,
                        'type' => $this->getMediaType($this->file_path->extension()),
                    ]);
                }
            }
    
            DB::commit();
    
            // Refresh data without resetting
            $this->generalContents();
            if (!empty($this->file_path)) {
                $this->coverMedias();
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Creation failed: ' . $e->getMessage());
            $this->addError('save', 'Failed to create post: ' . $e->getMessage());
        }
    }


    

    public function render()
    {
        return view('livewire.manage-site',);
    }
}
