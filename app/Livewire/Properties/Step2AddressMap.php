<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

class Step2AddressMap extends Component
{
    
    #[Validate('required|string')]
    public $address = '';

    #[Validate('required|numeric')]
    public $latitude = '';

    #[Validate('required|numeric')]
    public $longitude = '';

    private string $sessionKey;

    public function boot()
    {
        $this->sessionKey = "property_reg_" . auth()->id();
    }

    public function mount()
    {
        // FIX: Get all data first, then access step2
        $allData = session()->get($this->sessionKey, []);
        $step2Data = $allData['step2'] ?? [];

        $this->fill([
            'address' => $step2Data['address'] ?? '',
            'latitude' => $step2Data['latitude'] ?? '',
            'longitude' => $step2Data['longitude'] ?? '',
        ]);
    }

    #[On('setAddress')]
    public function setAddress($address, $lat, $lng)
    {
        $this->address = $address;
        $this->latitude = $lat;
        $this->longitude = $lng;

        $this->saveToSession();
    }

    private function saveToSession(): void
    {
        // FIX: Get all data, update step2, save everything back
        $allData = session()->get($this->sessionKey, []);

        $allData['step2'] = [
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];

        session()->put($this->sessionKey, $allData);
    }

    public function render()
    {
        return view('livewire.properties.step2-address-map');
    }
}
