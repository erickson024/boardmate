<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step2AddressMap extends Component
{
    public $address;
    public $latitude;
    public $longitude;

    protected $listeners = ['setAddress'];

    public function mount()
    {
        $data = session()->get('propertyRegistration', []);

        $this->address   = $data['address']   ?? '';
        $this->latitude  = $data['latitude']  ?? 14.5995;
        $this->longitude = $data['longitude'] ?? 120.9842;

        $this->dispatch('init-step2-map', [
            'lat' => $this->latitude,
            'lng' => $this->longitude,
        ]);
    }

    public function setAddress($address, $lat, $lng)
    {
        $this->address = $address;
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function submit()
    {
        session()->put('propertyRegistration', [
            ...session()->get('propertyRegistration', []),
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

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

