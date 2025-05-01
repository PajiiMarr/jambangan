<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Officers;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;

class OfficerComponent extends Component
{
    use WithFileUploads;

    protected $listeners = ['remove-officer' => 'removeOfficer'];
    public $chartData = [];
    public $selectedOrg = null;
    public $officer_input = [
        // 'officer_id' => null,
        'name' => '',
        'position' => '',
        'email' => '',
        'phone' => '',
        'address' => '',
        'pid' => null,
    ];
    
    public $profile_picture;

    public function render()
    {
        return view('livewire.officer-component', [
            'chartNodes' => $this->getChartData()
        ]);
    }

    public function addOfficer($data)
    {
        try {
            \Log::info('Adding officer with data:', $data);
            
            // Ensure parent_id is properly set
            $parentId = isset($data['pid']) ? $data['pid'] : null;
            \Log::info('Parent ID:', [
                'pid' => $parentId,
                'raw_data' => $data,
                'pid_type' => gettype($data['pid'] ?? null),
                'has_pid' => isset($data['pid'])
            ]);

            // Ensure all required fields have values
            $officerData = [
                'name' => $data['name'] ?? 'New Officer',
                'position' => $data['position'] ?? 'New Position',
                'email' => $data['email'] ?? 'temp_' . time() . '_' . uniqid() . '@temp.com',
                'phone' => $data['phone'] ?? '000-000-0000',
                'address' => $data['address'] ?? 'No Address',
                'user_id' => Auth::id(),
                'parent_id' => $parentId,
            ];

            \Log::info('Creating officer with data:', $officerData);

            // Check if email already exists
            $existingOfficer = Officers::where('email', $officerData['email'])->first();
            if ($existingOfficer) {
                // If email exists, generate a new one
                $officerData['email'] = 'temp_' . time() . '_' . uniqid() . '@temp.com';
            }

            $officer = Officers::create($officerData);

            \Log::info('Officer created:', [
                'officer_id' => $officer->officer_id, 
                'parent_id' => $officer->parent_id,
                'raw_parent_id' => $parentId,
                'parent_id_type' => gettype($officer->parent_id)
            ]);

            $this->dispatch('officerAdded', [
                'id' => $officer->officer_id,
                'pid' => $officer->parent_id,
                'tempId' => $data['id'] // Pass the temporary ID
            ]);
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Error in addOfficer: ' . $e->getMessage());
            $this->dispatch('error', message: $e->getMessage());
            return false;
        }
    }


    public function saveOfficer()
    {
        $data = $this->officer_input;

        $validatedData = $this->validate([
            'officer_input.name' => 'required|string|max:255',
            'officer_input.position' => 'required|string|max:255',
            'officer_input.email' => 'required|email',
            'officer_input.phone' => 'nullable|string',
            'officer_input.address' => 'nullable|string',
            'officer_input.pid' => 'nullable',
        ]);

        try {
            // Check if this is a temporary ID (starts with _)
            if ($data['officer_id'] && str_starts_with($data['officer_id'], '_')) {
                // This is a new officer being edited, create it
                $officer = Officers::create([
                    'name' => $data['name'],
                    'position' => $data['position'],
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? '',
                    'address' => $data['address'] ?? '',
                    'parent_id' => $data['pid'] ?? null,
                    'user_id' => Auth::id(),
                ]);
            } else {
                // This is an existing officer, update it
                $officer = Officers::findOrFail($data['officer_id']);
                
                // Check if email is being changed and if it's unique
                if ($officer->email !== $data['email'] && Officers::where('email', $data['email'])->exists()) {
                    throw new \Exception('Email already exists');
                }

                $officer->update([
                    'name' => $data['name'],
                    'position' => $data['position'],
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? '',
                    'address' => $data['address'] ?? '',
                    'parent_id' => $data['pid'] ?? null,
                ]);
            }

            // Handle profile picture if uploaded
            if ($this->profile_picture && method_exists($this->profile_picture, 'store')) {
                $path = $this->profile_picture->store('uploads', 's3');
                
                // Check if officer already has media
                $existingMedia = Media::where('officer_id', $officer->officer_id)->first();
                
                if ($existingMedia) {
                    $existingMedia->update([
                        'file_data' => $path,
                        'type' => 'image',
                    ]);
                } else {
                        Media::create([
                            'officer_id' => $officer->officer_id,
                            'file_data' => $path,
                            'type' => 'image',
                        ]);
                    }
                }

            $this->modal('edit-officer')->close();
            $this->js('window.chart.load(' . json_encode($this->getChartData()) . ')');

            $this->dispatch('officerUpdated', officer: $officer);
            session()->flash('message', 'Officer saved successfully!');
        } catch (\Exception $e) {
            \Log::error('Error in saveOfficer: ' . $e->getMessage());
            session()->flash('error', 'Failed to save officer: ' . $e->getMessage());
        }
    }



// Method to remove an officer
    // Method to remove an officer
// Method to remove an officer - with detailed debugging

public function removeOfficer($data)
{
    try {
        // Ensure we have an array
        if (!is_array($data)) {
            $data = ['id' => $data];
        }

        $id = $data['id'] ?? null;
        
        if (!$id) {
            \Log::error('No ID provided for removal');
            return false;
        }

        // Find the officer
        $officer = Officers::find($id);
        
        if (!$officer) {
            \Log::error('Officer not found', ['id' => $id]);
            return false;
        }

        // Delete associated media
        Media::where('officer_id', $id)->delete();
        
        // Delete the officer
        $deleted = $officer->delete();
        
        if ($deleted) {
            $this->dispatch('officer-removed', id: $id);
            // Refresh the chart data
            $this->js('window.chart.load(' . json_encode($this->getChartData()) . ')');
            return true;
        }
        
        return false;
    } catch (\Exception $e) {
        \Log::error('Removal error: ' . $e->getMessage());
        return false;
    }
}

public function getChartData()
{
    $officers = Officers::with('media')->get();
    
    return $officers->map(function ($officer) {
        // Debug log to see what we're working with
        // \Log::debug('Officer ID: ' . $officer->officer_id . ' - Media count: ' . $officer->media->count());
        
        // Instead of blindly taking the first media item, get the specific one for this officer
        $photoUrl = '';
        
        // Find the media specifically associated with this officer
        if ($officer->officer_id) {
            // Get media directly by officer_id to ensure we get the right one
            $mediaItem = Media::where('officer_id', $officer->officer_id)->latest()->first();
            
            if ($mediaItem && !empty($mediaItem->file_data)) {
                $photoUrl = \Storage::disk('s3')->url($mediaItem->file_data) . '?v=' . time();
            }
        }
        
        return [
            'id' => $officer->officer_id,
            'pid' => $officer->parent_id,
            'name' => $officer->name,
            'photo' => $photoUrl,
            'position' => $officer->position,
            'email' => $officer->email,
            'phone' => $officer->phone,
            'address' => $officer->address
        ];
    });
}

public function updateOfficerParent($data)
{
    try {
        \Log::info('Updating officer parent:', $data);
        
        $officer = Officers::find($data['id']);
        if (!$officer) {
            \Log::error('Officer not found:', $data);
            return false;
        }

        $officer->parent_id = $data['parent_id'];
        $officer->save();

        \Log::info('Officer parent updated:', [
            'officer_id' => $officer->officer_id,
            'new_parent_id' => $officer->parent_id
        ]);

        return true;
    } catch (\Exception $e) {
        \Log::error('Error updating officer parent: ' . $e->getMessage());
        return false;
    }
}
}
