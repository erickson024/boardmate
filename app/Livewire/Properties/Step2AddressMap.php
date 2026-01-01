<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step2AddressMap extends Component
{
    public $address, $latitude, $longitude;

    protected $rules = [
        'address' => 'required|string|max:255',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ];

    protected $listeners = ['setAddress' => 'updateMapData'];

    public function mount()
    {
        // Prefill if returning to this step
        $this->fill(session()->get('propertyRegistration', []));
    }

    public function updateMapData($address, $lat, $lng)  //bridge connection between js and php
    {
        $this->address = $address;
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function updatedCurrentStep($step)
    {
        if ($step === 2) {
            $this->dispatch('show-map');
        }
    }

    public function submit()
    {
        $this->validate();

        $propertyData = session()->get('propertyRegistration', []);
        $propertyData = array_merge($propertyData, [
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);
        session()->put('propertyRegistration', $propertyData);
        dd(session());
        // Proceed to the next step or finalize registration
        $this->dispatch('goToStep', 3);
    }

    public function back()
    {
        $this->dispatch('goToStep', 1);
    }

    public function render()
    {
        return view('livewire.properties.step2-address-map');
    }
}
