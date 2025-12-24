<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class PropertyRegistration extends Component
{
    
    public $currentStep = 1;

    protected $listeners = [
        'goToStep' => 'setStep'
    ];

    public function setStep($step)
    {
        $this->currentStep = $step;
    }

    public function render()
    {
        return view('livewire.properties.property-registration');
    }
}
