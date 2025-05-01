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
use App\Models\CoreValues;

class ManageSite extends Component
{
    use WithFileUploads;

    protected $listeners = ['postUploaded' => '$refresh'];

    #[Validate([
        'site_title' => 'required|string|max:255',
        'about_us' => 'required|string|max:1000',
        'contact_email' => 'required|email|max:255',
        'contact_number' => 'required|string|max:15',
        'address' => 'required|string|max:255',
        'logo_path' => 'nullable|image|max:1024', // 1MB Max
        'title' => 'nullable|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv|max:10240',
        'mission' => 'required|string|max:1000',
        'vision' => 'required|string|max:1000',
        'core_value_title' => 'nullable|string|max:255',
        'core_value_description' => 'nullable|string|max:1000',
        'emoji' => 'nullable|string|max:10',
    ])]

    public $editValues = [];
    public $coverEditValues = [];
    
    public $general_contents;


    public $site_title;
    public $about_us;
    public $contact_email;
    public $contact_number;
    public $address;
    public $logo_path;
    public $mission;
    public $vision;
    public $title;
    public $subtitle;
    public $file_path;
    public $core_value_title;
    public $core_value_description;
    public $emoji;

    public $core_values = [];


    public $cover_medias = [];
    public $selectedMediaId = null;

    public $showDeleteModal = false;

    public function mount()
    {
        $this->generalContents();
        $this->coverMedias();
        $this->coreValues();

        // Log::debug('djfhgjadhfkj' . $this->cover_medias);

        if($this->general_contents){
            $this->site_title = $this->general_contents->site_title;
            $this->about_us = $this->general_contents->about_us;
            $this->contact_email = $this->general_contents->contact_email;
            $this->contact_number = $this->general_contents->contact_number;
            $this->mission = $this->general_contents->mission;
            $this->vision = $this->general_contents->vision;
        }
    }

    public function coverMedias (){
        $this->cover_medias = Slides::select('slides.*', 'media.*')
            ->join('media', 'slides.slide_id', '=', 'media.slide_id')
            ->get();

        foreach ($this->cover_medias as $media) {
            $this->coverEditValues[$media->id] = [
                'title' => $media->title,
                'subtitle' => $media->subtitle,
                'file_path' => $media->file_data,
            ];
        }
        // dd($this->cover_medias);
    }

    public function coreValues(){
        $this->core_values = CoreValues::all();

        foreach ($this->core_values as $core) {
            $this->editValues[$core->id] = [
                'title' => $core->core_value_title,
                'description' => $core->core_value_description,
                'emoji' => $core->emoji,
            ];
        }
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
        Log::debug('Mission: ' . $this->mission);
        Log::debug('Vision: ' . $this->vision);
        Log::debug('Cover Title: ' . $this->title);
        Log::debug('Cover Sub-title: ' . $this->subtitle);
        Log::debug('Core Value Title: ' . $this->core_value_title);
        Log::debug('Core Value Description: ' . $this->core_value_description); 
        Log::debug('Address: ' . $this->address);
        try {
            DB::beginTransaction();

            if ($this->logo_path) {
                // Store the file and get the path (relative to disk root)
                $logoPath = $this->logo_path->store('logos', 's3');
                
                // Get the public URL if needed
                $logoUrl = Storage::disk('s3')->url($logoPath);
            }

            if ($this->core_value_title && $this->core_value_description) {
                CoreValues::create([
                    'core_value_title' => $this->core_value_title,
                    'core_value_description' => $this->core_value_description,
                    'emoji' => $this->emoji,
                ]);
            }

    
            // Save general settings
            $general = General::updateOrCreate(
                ['id' => $this->general_contents->id ?? null],
                [
                    'site_title' => $this->site_title,
                    'about_us' => $this->about_us,
                    'contact_email' => $this->contact_email,
                    'contact_number' => $this->contact_number,
                    'logo_path' => $logoUrl ?? '',
                    'mission' => $this->mission,
                    'vision' => $this->vision,
                    'address' => $this->address,
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

            Log::debug('Saved successfully' . $this->general_contents);   
    
            // Refresh data without resetting
            $this->coreValues();
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

    public function deleteCoreValue($id)
    {
        try {
            DB::beginTransaction();
            
            $coreValue = CoreValues::findOrFail($id);
            $coreValue->delete();
            
            DB::commit();
            
            // Close modal and refresh data
            $this->dispatch('close-modal', ['name' => 'delete-core-value-' . $id]);
            $this->coreValues();
            
            session()->flash('message', 'Core value deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete core value failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete core value: ' . $e->getMessage());
        }
    }
    
    public function updateCoreValue($id)
    {
        $title = $this->editValues[$id]['title'] ?? null;
        $description = $this->editValues[$id]['description'] ?? null;
        $emoji = $this->editValues[$id]['emoji'] ?? null;
    
        if ($title && $description) {
            $coreValue = CoreValues::findOrFail($id);
            $coreValue->core_value_title = $title;
            $coreValue->core_value_description = $description;
            $coreValue->emoji = $emoji;
            $coreValue->save();
            
            $this->modal('edit-core-value-' . $id)->close();
            $this->coreValues(); // refresh the list
        } else {
            $this->addError('editValues', 'Both title and description are required.');
        }
    }

    public function updateCoverMedia($mediaId)  // Now expects media ID
    {
        try {
            DB::beginTransaction();
            
            // Find the media record
            $media = Media::findOrFail($mediaId);
            
            // Find and update the related slide
            $slide = Slides::findOrFail($media->slide_id);
            $slide->update([
                'title' => $this->coverEditValues[$mediaId]['title'],
                'subtitle' => $this->coverEditValues[$mediaId]['subtitle']
            ]);
    
            // Update media file if new file was uploaded
            if ($this->file_path) {
                // Delete old file from storage
                Storage::disk('s3')->delete($media->file_data);
                
                // Store new file
                $path = $this->file_path->store('uploads', 's3');
                $media->update([
                    'file_data' => $path,
                    'type' => $this->getMediaType($this->file_path->extension())
                ]);
            }
    
            DB::commit();
            $this->modal('edit-cover-media-' . $mediaId)->close();
            $this->coverMedias(); // Refresh data
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update cover media failed: ' . $e->getMessage());
            $this->addError('updateCoverMedia', 'Failed to update cover media');
        }
    }
    
    public function confirmDelete($mediaId)
    {
        $this->selectedMediaId = $mediaId;
        $this->showDeleteModal = true;
    }

    public function deleteCoverMedia()
    {
        try {
            DB::beginTransaction();
            
            // Find the media record using media_id
            $media = Media::where('media_id', $this->selectedMediaId)->firstOrFail();
            
            // Get related slide before deletion
            $slideId = $media->slide_id;
            
            // Delete the media file from storage
            if (Storage::disk('s3')->exists($media->file_data)) {
                Storage::disk('s3')->delete($media->file_data);
            }
            
            // Delete the media record
            $media->delete();
            
            // Delete the related slide
            Slides::findOrFail($slideId)->delete();
            
            DB::commit();
            
            // Reset modal state and refresh data
            $this->showDeleteModal = false;
            $this->selectedMediaId = null;
            $this->coverMedias();
            
            session()->flash('message', 'Cover media deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete cover media failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete cover media: ' . $e->getMessage());
        }
    }

    public function saveSiteIdentity()
    {
        try {
            DB::beginTransaction();
            
            $general = General::updateOrCreate(
                ['id' => $this->general_contents->id ?? null],
                [
                    'site_title' => $this->site_title,
                    'about_us' => $this->about_us,
                ]
            );
            
            DB::commit();
            $this->generalContents();
            session()->flash('message', 'Site identity updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Save site identity failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to update site identity: ' . $e->getMessage());
        }
    }

    public function saveMissionVision()
    {
        try {
            DB::beginTransaction();
            
            $general = General::updateOrCreate(
                ['id' => $this->general_contents->id ?? null],
                [
                    'mission' => $this->mission,
                    'vision' => $this->vision,
                ]
            );
            
            DB::commit();
            $this->generalContents();
            session()->flash('message', 'Mission and Vision updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Save mission and vision failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to update mission and vision: ' . $e->getMessage());
        }
    }

    public function saveCoreValue()
    {
        try {
            DB::beginTransaction();
            
            if ($this->core_value_title && $this->core_value_description) {
                CoreValues::create([
                    'core_value_title' => $this->core_value_title,
                    'core_value_description' => $this->core_value_description,
                    'emoji' => $this->emoji,
                ]);
            }
            
            DB::commit();
            $this->coreValues();
            $this->core_value_title = '';
            $this->core_value_description = '';
            $this->emoji = '';
            session()->flash('message', 'Core value added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Save core value failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to add core value: ' . $e->getMessage());
        }
    }

    public function saveContactDetails()
    {
        try {
            DB::beginTransaction();
            
            $general = General::updateOrCreate(
                ['id' => $this->general_contents->id ?? null],
                [
                    'contact_email' => $this->contact_email,
                    'contact_number' => $this->contact_number,
                    'address' => $this->address,
                ]
            );
            
            DB::commit();
            $this->generalContents();
            session()->flash('message', 'Contact details updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Save contact details failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to update contact details: ' . $e->getMessage());
        }
    }

    public function saveCoverMedia()
    {
        try {
            DB::beginTransaction();
            
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
                    $url = Storage::disk('s3')->url($path);
    
                    Media::create([
                        'slide_id' => $slides['slide_id'],
                        'file_data' => $path,
                        'type' => $this->getMediaType($this->file_path->extension()),
                    ]);
                }
            }
            
            DB::commit();
            $this->coverMedias();
            $this->title = '';
            $this->subtitle = '';
            $this->file_path = null;
            session()->flash('message', 'Cover media added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Save cover media failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to add cover media: ' . $e->getMessage());
        }
    }

    public function saveLogo()
    {
        try {
            DB::beginTransaction();
            
            if ($this->logo_path) {
                $logoPath = $this->logo_path->store('logos', 's3');
                $logoUrl = Storage::disk('s3')->url($logoPath);
                
                $general = General::updateOrCreate(
                    ['id' => $this->general_contents->id ?? null],
                    ['logo_path' => $logoUrl]
                );
            }
            
            DB::commit();
            $this->generalContents();
            $this->logo_path = null;
            session()->flash('message', 'Logo updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Save logo failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to update logo: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.manage-site',);
    }
}
