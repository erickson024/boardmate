<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step3Features extends Component
{
    public array $propertyFeatures = [];

    public array $propertyFeatureIcons = [
        // Utilities & Comfort
        'Wi-Fi'                => 'fas fa-wifi',
        'Telephone'            => 'fas fa-phone',
        'Air Conditioning'     => 'fas fa-snowflake',
        'Heater'               => 'fas fa-thermometer-half',
        'Electric Fan'         => 'fas fa-fan',

        // Entertainment
        'Smart TV'             => 'fas fa-tv',
        'Cable TV'             => 'fas fa-broadcast-tower',
        'Karaoke'              => 'fas fa-microphone',

        // Bathroom
        'Hot Shower'           => 'fas fa-shower',
        'Bathtub'              => 'fas fa-bath',
        'Smart Toilet'         => 'fas fa-toilet',

        // Interior
        'Fully Furnished'      => 'fas fa-couch',
        'Wardrobe / Closet'    => 'fas fa-door-closed',
        'Balcony'              => 'fas fa-archway',
        'Laundry Area'         => 'fas fa-tshirt',

        // Kitchen
        'Kitchen'              => 'fas fa-kitchen-set',
        'Refrigerator'         => 'fas fa-snowflake',
        'Microwave'            => 'fas fa-box',
        'Rice Cooker'          => 'fas fa-mug-hot',

        // Security
        'CCTV'                 => 'fas fa-video',
        '24/7 Guarded'         => 'fas fa-shield-alt',
        'Gated Property'       => 'fas fa-door-closed',
        'Fire Alarm'           => 'fas fa-fire',

        // Parking
        'Parking Space'        => 'fas fa-car',
        'Motorcycle Parking'   => 'fas fa-motorcycle',

        // Nearby Locations
        'Near School'          => 'fas fa-school',
        'Near Market'          => 'fas fa-store',
        'Near Convenience Store' => 'fas fa-shopping-bag',
        'Near Public Transport' => 'fas fa-bus',
        'Near Park'            => 'fas fa-tree',
        'Near Hospital'        => 'fas fa-hospital',
        'Near Police Station'  => 'fas fa-shield-alt',
    ];

    public array $featureColors = [
        // Utilities & Comfort
        'Wi-Fi' => 'bg-primary',
        'Telephone' => 'bg-primary',
        'Air Conditioning' => 'bg-primary',
        'Heater' => 'bg-primary',
        'Electric Fan' => 'bg-primary',

        // Entertainment
        'Smart TV' => 'bg-warning',
        'Cable TV' => 'bg-warning',
        'Karaoke' => 'bg-warning',

        // Bathroom
        'Hot Shower' => 'bg-dark',
        'Bathtub' => 'bg-dark',
        'Smart Toilet' => 'bg-dark',

        // Interior
        'Fully Furnished' => 'bg-info',
        'Wardrobe / Closet' => 'bg-info',
        'Balcony' => 'bg-info',
        'Laundry Area' => 'bg-info',

        // Kitchen
        'Kitchen' => 'bg-secondary',
        'Refrigerator' => 'bg-secondary',
        'Microwave' => 'bg-secondary',
        'Rice Cooker' => 'bg-secondary',

        // Security
        'CCTV' => 'bg-danger',
        '24/7 Guarded' => 'bg-danger',
        'Gated Property' => 'bg-danger',
        'Fire Alarm' => 'bg-danger',

        // Parking
        'Parking Space' => 'bg-secondary',
        'Motorcycle Parking' => 'bg-secondary',

        // Nearby Locations
        'Near School' => 'bg-success',
        'Near Market' => 'bg-success',
        'Near Convenience Store' => 'bg-success',
        'Near Public Transport' => 'bg-success',
        'Near Park' => 'bg-success',
        'Near Hospital' => 'bg-success',
        'Near Police Station' => 'bg-success',
    ];

    protected $listeners = [
        'validateStep3' => 'validateCurrentStep'
    ];

    protected $rules = [
        'propertyFeatures' => 'array|min:1',
    ];

    protected $messages = [
        'propertyFeatures.required' => 'Please select at least one feature.',
        'propertyFeatures.min' => 'Please select at least one feature.',
    ];

    public function mount()
    {
        // Load from session if exists
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";
        
        $saved = session()->get($sessionKey, []);
        $step3Data = $saved['step3'] ?? [];
        
        $this->propertyFeatures = $step3Data['propertyFeatures'] ?? [];
    }

    public function validateCurrentStep()
    {
        $this->validate();

        // Save to session before moving to next step
        $this->saveToSession();
        
        // If validation passes, go to next step
        $this->dispatch('nextStep');
    }

    private function saveToSession()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        // Get existing session data
        $data = session()->get($sessionKey, []);
        
        // Update with step 3 data
        $data['step3'] = [
            'propertyFeatures' => $this->propertyFeatures,
        ];
    
        // Save back to session
        session()->put($sessionKey, $data);
    }

    public function render()
    {
        return view('livewire.properties.step3-features');
    }
}