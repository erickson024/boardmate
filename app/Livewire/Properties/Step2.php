<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step2 extends Component
{
    public $address, $latitude, $longitude;

    protected $rules = [
        'address' =>  'required|string|max:255',
        'latitude' =>  'required|numeric',
        'longitude' =>  'required|numeric',
    ];

    public function mount()
    {
        $this->fill(session()->get('property_reg', []));
    }

    protected $listeners = ['setAddress' => 'updateMapData'];

    public function updateMapData($address, $lat, $lng)
    {
        $this->address = $address;
        $this->latitude = $lat;
        $this->longitude = $lng;
    }


    public function submit()
    {
        $this->validate();
        $registrationData = session()->get('property_reg', []);
        $registrationData = array_merge($registrationData, [
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

        session()->put('property_reg', $registrationData);
    

        $this->dispatch('goToStep', 3);
    }

    public function back()
    {
        $this->dispatch('goToStep', 1);
    }
    public function render()
    {
        return view('livewire.properties.step2');
    }
}
