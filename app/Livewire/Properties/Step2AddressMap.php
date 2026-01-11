<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step2AddressMap extends Component
{
    public $address = '';
    public $latitude = '';
    public $longitude = '';

    protected $listeners = [
        'setAddress',
        'validateStep2' => 'validateCurrentStep'
    ];

    public function setAddress($address, $lat, $lng)
    {
        $this->address = $address;
        $this->latitude = $lat;
        $this->longitude = $lng;
        
        $this->saveToSession();
    }

    public function validateCurrentStep()
    {
        $this->validate([
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ], [
            'address.required' => 'Please select a valid address from the search',
            'latitude.required' => 'Please select a location on the map',
            'longitude.required' => 'Please select a location on the map',
        ]);

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
        
        // Update with step 2 data
        $data['step2'] = [
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
        
        // Save back to session
        session()->put($sessionKey, $data);
    }

    public function mount()
    {
        // Load from session if exists
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";
        
        $saved = session()->get($sessionKey, []);
        $step2Data = $saved['step2'] ?? [];
        
        $this->address = $step2Data['address'] ?? '';
        $this->latitude = $step2Data['latitude'] ?? '';
        $this->longitude = $step2Data['longitude'] ?? '';
    }

    public function render()
    {
        return view('livewire.properties.step2-address-map');
    }
}