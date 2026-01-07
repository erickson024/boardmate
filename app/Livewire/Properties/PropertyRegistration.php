<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class PropertyRegistration extends Component
{
  
    public $currentStep = 1;
    public $maxSteps = 5;
    
    // Listeners
    protected $listeners = [
        'nextStep',
        'prevStep',
        'goToStep' => 'setStep',
    ];

    public function nextStep()
    {
        if ($this->currentStep < $this->maxSteps) {
            $this->currentStep++;
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }
    
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
