<?php

namespace App\Livewire\Users\Dashboard;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class HostPropertyDetails extends Component
{
    use WithFileUploads;

    public $propertyId;
    public $property;

    // Property fields
    public $propertyName;
    public $propertyType;
    public $address = '';
    public $propertyCost;
    public $propertyDescription;
    public $latitude = '';
    public $longitude = '';
    public $tenantGender;
    public $tenantType;
    public $terms;

    // JSON fields
    public $propertyFeatures = [];
    public $propertyRestrictions = [];

    // Image handling
    public $images = [];
    public $newImages = [];
    public $imagesToDelete = [];

    // Property types configuration
    public array $propertyTypes = [
        'apartment' => 'Apartment',
        'condominium'  => 'Condominium',
        'house' => 'House',
        'studio' => 'Studio',
        'dormitory' => 'Dormitory',
        'bedspace' => 'Bedspace'
    ];

    public array $propertyTypeIcons = [
        'apartment'   => 'bi bi-building-fill',
        'condominium' => 'bi bi-buildings-fill',
        'house'       => 'bi bi-house-fill',
        'studio'      => 'bi bi-door-closed-fill',
        'dormitory'   => 'bi-people-fill',
        'bedspace'    => 'bi bi-person-standing'
    ];

    // Tenant preferences configuration
    public array $genders = [
        'male' => [
            'label' => 'Male',
            'icon'  => 'fas fa-mars',
        ],
        'female' => [
            'label' => 'Female',
            'icon'  => 'fas fa-venus',
        ],
        'all' => [
            'label' => 'All',
            'icon'  => 'fas fa-venus-mars',
        ],
    ];

    public array $types = [
        'student' => [
            'label' => 'Student',
            'icon'  => 'fas fa-graduation-cap',
            'color' => 'primary',
        ],
        'employee' => [
            'label' => 'Employee',
            'icon'  => 'fas fa-briefcase',
            'color' => 'success',
        ],
        'family' => [
            'label' => 'Family',
            'icon'  => 'fas fa-home',
            'color' => 'warning',
        ],
        'single' => [
            'label' => 'Single',
            'icon'  => 'fas fa-user',
            'color' => 'info',
        ],
        'groups' => [
            'label' => 'Groups',
            'icon'  => 'fas fa-users',
            'color' => 'danger',
        ],
        'couple' => [
            'label' => 'Couple',
            'icon'  => 'fas fa-heart',
            'color' => 'danger',
        ],
        'all' => [
            'label' => 'All',
            'icon'  => 'fas fa-users',
            'color' => 'secondary',
        ],
    ];

    // Feature icons and colors
    public array $propertyFeatureIcons = [
        'Wi-Fi' => 'fas fa-wifi',
        'Telephone' => 'fas fa-phone',
        'Air Conditioning' => 'fas fa-snowflake',
        'Heater' => 'fas fa-thermometer-half',
        'Electric Fan' => 'fas fa-fan',
        'Smart TV' => 'fas fa-tv',
        'Cable TV' => 'fas fa-broadcast-tower',
        'Karaoke' => 'fas fa-microphone',
        'Hot Shower' => 'fas fa-shower',
        'Bathtub' => 'fas fa-bath',
        'Smart Toilet' => 'fas fa-toilet',
        'Fully Furnished' => 'fas fa-couch',
        'Wardrobe / Closet' => 'fas fa-door-closed',
        'Balcony' => 'fas fa-archway',
        'Laundry Area' => 'fas fa-tshirt',
        'Kitchen' => 'fas fa-kitchen-set',
        'Refrigerator' => 'fas fa-snowflake',
        'Microwave' => 'fas fa-box',
        'Rice Cooker' => 'fas fa-mug-hot',
        'CCTV' => 'fas fa-video',
        '24/7 Guarded' => 'fas fa-shield-alt',
        'Gated Property' => 'fas fa-door-closed',
        'Fire Alarm' => 'fas fa-fire',
        'Parking Space' => 'fas fa-car',
        'Motorcycle Parking' => 'fas fa-motorcycle',
        'Near School' => 'fas fa-school',
        'Near Market' => 'fas fa-store',
        'Near Convenience Store' => 'fas fa-shopping-bag',
        'Near Public Transport' => 'fas fa-bus',
        'Near Park' => 'fas fa-tree',
        'Near Hospital' => 'fas fa-hospital',
        'Near Police Station' => 'fas fa-shield-alt',
    ];

    public array $featureColors = [
        'Wi-Fi' => 'bg-primary',
        'Telephone' => 'bg-primary',
        'Air Conditioning' => 'bg-primary',
        'Heater' => 'bg-primary',
        'Electric Fan' => 'bg-primary',
        'Smart TV' => 'bg-warning',
        'Cable TV' => 'bg-warning',
        'Karaoke' => 'bg-warning',
        'Hot Shower' => 'bg-dark',
        'Bathtub' => 'bg-dark',
        'Smart Toilet' => 'bg-dark',
        'Fully Furnished' => 'bg-info',
        'Wardrobe / Closet' => 'bg-info',
        'Balcony' => 'bg-info',
        'Laundry Area' => 'bg-info',
        'Kitchen' => 'bg-secondary',
        'Refrigerator' => 'bg-secondary',
        'Microwave' => 'bg-secondary',
        'Rice Cooker' => 'bg-secondary',
        'CCTV' => 'bg-danger',
        '24/7 Guarded' => 'bg-danger',
        'Gated Property' => 'bg-danger',
        'Fire Alarm' => 'bg-danger',
        'Parking Space' => 'bg-secondary',
        'Motorcycle Parking' => 'bg-secondary',
        'Near School' => 'bg-success',
        'Near Market' => 'bg-success',
        'Near Convenience Store' => 'bg-success',
        'Near Public Transport' => 'bg-success',
        'Near Park' => 'bg-success',
        'Near Hospital' => 'bg-success',
        'Near Police Station' => 'bg-success',
    ];

    public array $propertyRestrictionIcons = [
        'No Smoking' => 'fas fa-smoking-ban',
        'No Vaping' => 'fas fa-ban-smoking',
        'No Alcohol' => 'fas fa-ban',
        'No Drugs' => 'fas fa-pills',
        'No Parties' => 'fas fa-ban',
        'No Events' => 'fas fa-calendar-xmark',
        'No Loud Music' => 'fas fa-volume-xmark',
        'No Pets' => 'fas fa-dog',
        'Small Pets Only' => 'fas fa-paw',
        'No Overnight Guests' => 'fas fa-user-slash',
        'Limited Visitors Only' => 'fas fa-user-clock',
        'Registration Required for Guests' => 'fas fa-id-card',
        'Quiet Hours Enforced' => 'fas fa-moon',
        'No Noise' => 'fas fa-clock',
        'Respect Neighbors' => 'fas fa-handshake',
        'Curfew Enforced' => 'fas fa-clock',
        'No Cooking' => 'fas fa-fire-extinguisher',
        'No Open Flames' => 'fas fa-fire',
        'No Candles' => 'fas fa-burn',
        'No Incense' => 'fas fa-wind',
        'No Wall Drilling' => 'fas fa-screwdriver',
        'No Wall Painting' => 'fas fa-paint-roller',
        'No Furniture Rearranging' => 'fas fa-couch',
        'No Nails or Hooks' => 'fas fa-thumbtack',
        'No Laundry' => 'fas fa-ban',
        'No Business Use' => 'fas fa-ban',
        'Residential Use Only' => 'fas fa-house-user',
        'No Overnight Parking' => 'fas fa-parking',
        'No Commercial Vehicles' => 'fas fa-truck',
    ];

    protected $rules = [
        'propertyName' => 'required|string|max:255',
        'propertyType' => 'required|in:apartment,condominium,dormitory,studio,bedspace,house',
        'address' => 'required|string|max:500',
        'propertyCost' => 'required|numeric|min:0',
        'propertyDescription' => 'nullable|string',
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
        'tenantType' => 'required|in:employee,student,family,groups,single,couple,all',
        'tenantGender' => 'required|in:male,female,all',
        'terms' => 'nullable|string',
        'newImages' => 'nullable|array|max:5',
        'newImages.*' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
    ];

    protected $messages = [
        'address.required' => 'Please select a valid address from the search',
        'latitude.required' => 'Please select a location on the map',
        'longitude.required' => 'Please select a location on the map',
        'newImages.max' => 'You can upload up to 5 images only.',
        'newImages.*.image' => 'Only image files are allowed.',
        'newImages.*.mimes' => 'Images must be JPEG, PNG, or WEBP format.',
        'newImages.*.max' => 'Each image must not exceed 2MB.',
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
        $this->address = $this->property->address ?? '';
        $this->propertyCost = $this->property->propertyCost;
        $this->propertyDescription = $this->property->propertyDescription;
        $this->latitude = $this->property->latitude ?? '';
        $this->longitude = $this->property->longitude ?? '';
        $this->tenantType = $this->property->tenantType;
        $this->tenantGender = $this->property->tenantGender;
        $this->terms = $this->property->terms;
        $this->propertyFeatures = $this->property->propertyFeatures ?? [];
        $this->propertyRestrictions = $this->property->propertyRestrictions ?? [];
        $this->images = $this->property->images ?? [];
    }

    public function removeExistingImage($index)
    {
        if (isset($this->images[$index])) {
            $this->imagesToDelete[] = $this->images[$index];
            unset($this->images[$index]);
            $this->images = array_values($this->images);
        }
        $this->resetErrorBag();
    }

    public function removeNewImage($index)
    {
        if (isset($this->newImages[$index])) {
            unset($this->newImages[$index]);
            $this->newImages = array_values($this->newImages);
        }
        $this->resetErrorBag();
    }

    public function updatedNewImages()
    {
        // Validate individual images first
        $this->validate([
            'newImages.*' => 'image|mimes:jpeg,png,webp|max:2048'
        ]);

        // Check if total images would exceed limit
        $totalImages = count($this->images) + count($this->newImages);
        if ($totalImages > 5) {
            $allowed = 5 - count($this->images);
            $this->addError('newImages', "Cannot upload more than 5 images total. You can only add {$allowed} more image(s).");
            $this->newImages = [];
            return;
        }

        // Clear any previous errors
        $this->resetErrorBag();
    }

    public function saveChanges()
    {
        $this->validate();

        try {
            // Delete removed images
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
                'propertyDescription' => $this->propertyDescription,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'tenantType' => $this->tenantType,
                'tenantGender' => $this->tenantGender,
                'terms' => $this->terms,
                'propertyFeatures' => $this->propertyFeatures,
                'propertyRestrictions' => $this->propertyRestrictions,
                'images' => $allImages,
            ]);

            // Reset state
            $this->loadProperty();
            $this->newImages = [];
            $this->imagesToDelete = [];

            session()->flash('success', 'Property updated successfully!');
            $this->dispatch('propertyUpdated');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update property: ' . $e->getMessage());
        }
    }

    public function deleteProperty()
    {
        try {
            // Delete all property images
            foreach ($this->property->images ?? [] as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            $this->property->delete();

            session()->flash('success', 'Property deleted successfully!');

            return redirect()->route('user.dashboard', ['tab' => 'property-list']);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete property: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.users.dashboard.host-property-details');
    }
}