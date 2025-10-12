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

    protected $listeners = ['setAddress' => 'updateMapData'];

    public function mount()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        // Prefill if returning to this step
        $this->fill(session()->get($sessionKey, []));
    }


    public function updateMapData($address, $lat, $lng)
    {
        $this->address = $address;
        $this->latitude = $lat;
        $this->longitude = $lng;
    }


    public function submit()
    {
        $this->validate();

        // ✅ Consistent session key pattern
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        // Merge Step 2 data with existing session
        $data = session()->get($sessionKey, []);
        $data = array_merge($data, [
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

        // Save back to session
        session()->put($sessionKey, $data);

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
