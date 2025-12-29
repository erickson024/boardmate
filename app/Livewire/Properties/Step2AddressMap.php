<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step2AddressMap extends Component
{
    public function back()
    {
        $this->dispatch('goToStep', 1);
    }
    
    public function render()
    {
        return view('livewire.properties.step2-address-map');
    }
}
