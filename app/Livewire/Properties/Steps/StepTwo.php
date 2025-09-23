<?php

namespace App\Livewire\Properties\Steps;

use Livewire\Component;

class StepTwo extends Component
{
        public $address;
    public $lat;
    public $lng;

    protected $listeners = ['showStepTwo' => 'initMap'];

    public function initMap()
    {
        $this->dispatchBrowserEvent('init-map', [
            'address' => $this->address,
            'lat' => $this->lat,
            'lng' => $this->lng,
        ]);
    }

    public function updatedAddress($value)
    {
        // sync if user edits manually
    }

    
    public function render()
    {
        return view('livewire.properties.steps.step-two');
    }
}
