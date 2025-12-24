<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step2 extends Component
{
    public $address, $latitude, $longitude;

    protected $rules = [
        'address'   => 'required|string|min:10|max:255',
        'latitude'  => 'required|numeric',
        'longitude' => 'required|numeric',
    ];

    protected $listeners = ['setAddress' => 'updateMapData'];

    public function updatedAddress($value)
    {
        if (blank($value)) {
            $this->latitude = null;
            $this->longitude = null;
        }
    }

    public function mount()
    {
        $this->fill(
            session()->get("property_reg_" . auth()->id(), [])
        );
    }

    public function updateMapData($address, $lat, $lng)
    {
        $this->address = $address;
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function back()
    {
       
        $this->dispatch('goToStep', 1);
    }

    public function submit()
    {
        $this->validate();

        session()->put(
            "property_reg_" . auth()->id(),
            array_merge(
                session()->get("property_reg_" . auth()->id(), []),
                [
                    'address' => $this->address,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                ]
            )
        );

        $this->dispatch('goToStep', 3);
    }
}
