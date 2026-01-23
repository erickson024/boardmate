<?php

namespace App\Livewire\Users\Dashboard;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PropertyDetails extends Component
{
    use WithFileUploads;

    public $propertyId;
    public $property;
    
    // Property fields
    public $propertyName;
    public $propertyType;
    public $address;
    public $propertyCost;
    public $tenantType;
    public $tenantGender;
    public $status;
    public $description;
    
    // Image handling
    public $images = [];
    public $newImages = [];
    public $imagesToDelete = [];
    
    // UI state
    public $isEditing = false;

    protected $rules = [
        'propertyName' => 'required|string|max:255',
        'propertyType' => 'required|string',
        'address' => 'required|string|max:500',
        'propertyCost' => 'required|numeric|min:0',
        'tenantType' => 'nullable|string',
        'tenantGender' => 'nullable|string',
        'status' => 'required|in:active,inactive,draft',
        'description' => 'nullable|string|max:1000',
        'newImages.*' => 'nullable|image|max:2048', // 2MB max
    ];

    public function mount($propertyId)
    {
        $this->propertyId = $propertyId;
        $this->loadProperty();
    }

    public function loadProperty()
    {
        $this->property = Property::where('id', $this->propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->propertyName = $this->property->propertyName;
        $this->propertyType = $this->property->propertyType;
        $this->address = $this->property->address;
        $this->propertyCost = $this->property->propertyCost;
        $this->tenantType = $this->property->tenantType;
        $this->tenantGender = $this->property->tenantGender;
        $this->status = $this->property->status ?? 'draft';
        $this->description = $this->property->description;
        $this->images = $this->property->images ?? [];
    }

    public function toggleEdit()
    {
        $this->isEditing = !$this->isEditing;
        
        if (!$this->isEditing) {
            // Reset to original values if canceling
            $this->loadProperty();
            $this->newImages = [];
            $this->imagesToDelete = [];
        }
    }

    public function removeExistingImage($index)
    {
        if (isset($this->images[$index])) {
            $this->imagesToDelete[] = $this->images[$index];
            unset($this->images[$index]);
            $this->images = array_values($this->images); // Re-index array
        }
    }

    public function removeNewImage($index)
    {
        if (isset($this->newImages[$index])) {
            unset($this->newImages[$index]);
            $this->newImages = array_values($this->newImages);
        }
    }

    public function update()
    {
        $this->validate();

        try {
            // Delete removed images from storage
            foreach ($this->imagesToDelete as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            // Upload new images
            $uploadedImages = [];
            foreach ($this->newImages as $image) {
                $path = $image->store('properties', 'public');
                $uploadedImages[] = $path;
            }

            // Merge existing and new images
            $allImages = array_merge($this->images, $uploadedImages);

            // Update property
            $this->property->update([
                'propertyName' => $this->propertyName,
                'propertyType' => $this->propertyType,
                'address' => $this->address,
                'propertyCost' => $this->propertyCost,
                'tenantType' => $this->tenantType,
                'tenantGender' => $this->tenantGender,
                'status' => $this->status,
                'description' => $this->description,
                'images' => $allImages,
            ]);

            // Reset state
            $this->loadProperty();
            $this->newImages = [];
            $this->imagesToDelete = [];
            $this->isEditing = false;

            session()->flash('success', 'Property updated successfully!');
            
            // Dispatch event to refresh property list if needed
            $this->dispatch('propertyUpdated');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update property: ' . $e->getMessage());
        }
    }

    public function deleteProperty()
    {
        try {
            // Delete all images
            foreach ($this->property->images ?? [] as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            $this->property->delete();

            session()->flash('success', 'Property deleted successfully!');
            
            return redirect()->route('property-list');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete property: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.users.dashboard.property-details');
    }
}