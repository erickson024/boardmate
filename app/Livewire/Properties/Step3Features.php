<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;


class Step3Features extends Component
{
    #[Validate('required|array|min:1')]
    public array $propertyFeatures = [];

    public array $propertyFeatureIcons = [
        // Utilities & Comfort
        'Wi-Fi' => 'fas fa-wifi',
        'Telephone' => 'fas fa-phone',
        'Air Conditioning' => 'fas fa-snowflake',
        'Heater' => 'fas fa-thermometer-half',
        'Electric Fan' => 'fas fa-fan',
        // Entertainment
        'Smart TV' => 'fas fa-tv',
        'Cable TV' => 'fas fa-broadcast-tower',
        'Karaoke' => 'fas fa-microphone',
        // Bathroom
        'Hot Shower' => 'fas fa-shower',
        'Bathtub' => 'fas fa-bath',
        'Smart Toilet' => 'fas fa-toilet',
        // Interior
        'Fully Furnished' => 'fas fa-couch',
        'Wardrobe / Closet' => 'fas fa-door-closed',
        'Balcony' => 'fas fa-archway',
        'Laundry Area' => 'fas fa-tshirt',
        // Kitchen
        'Kitchen' => 'fas fa-kitchen-set',
        'Refrigerator' => 'fas fa-snowflake',
        'Microwave' => 'fas fa-box',
        'Rice Cooker' => 'fas fa-mug-hot',
        // Security
        'CCTV' => 'fas fa-video',
        '24/7 Guarded' => 'fas fa-shield-alt',
        'Gated Property' => 'fas fa-door-closed',
        'Fire Alarm' => 'fas fa-fire',
        // Parking
        'Parking Space' => 'fas fa-car',
        'Motorcycle Parking' => 'fas fa-motorcycle',
        // Nearby Locations
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

    private string $sessionKey;

    public function boot()
    {
        $this->sessionKey = "property_reg_" . auth()->id();
    }

    public function mount()
    {
        $step3Data = session()->get("{$this->sessionKey}.step3", []);
        $this->propertyFeatures = $step3Data['propertyFeatures'] ?? [];
    }

    public function updatedPropertyFeatures()
    {
        // Clear validation errors when user makes a selection
        $this->resetValidation('propertyFeatures');
        $this->saveToSession();
    }

    private function saveToSession(): void
    {
        session()->put("{$this->sessionKey}.step3", [
            'propertyFeatures' => $this->propertyFeatures
        ]);
    }

    #[On('validationErrors')]
    public function handleValidationErrors($step, $errors)
    {
        if ($step === 3 && isset($errors['propertyFeatures'])) {
            // Set the error on this component
            $this->addError('propertyFeatures', $errors['propertyFeatures'][0]);
        }
    }

    public function render()
    {
        return view('livewire.properties.step3-features');
    }
}