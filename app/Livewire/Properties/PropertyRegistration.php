<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class PropertyRegistration extends Component
{
    // Current Step
    public $currentStep = 1;
    
    // Listeners
    protected $listeners = [
        'goToStep' => 'setStep',
    ];
    
    // Set Current Step
    public function setStep($step)
    {
        $this->currentStep = $step;
    }
    
    // Go to Home
    public function goToHome()
    {
        session()->forget('propertyRegistration');
        return $this->redirect(route('home'), navigate: true);
    }

    public function render()
    {
        return view('livewire.properties.property-registration');
    }
}
