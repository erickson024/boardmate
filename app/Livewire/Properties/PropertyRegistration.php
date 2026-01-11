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
    ];

    public function mount()
    {
        // Clean up old session structure on mount
        session()->forget('propertyRegistration');
    }
    
     public function continueStep()
    {
        // Dispatch validation event to child
        $this->dispatch('validateStep' . $this->currentStep);
    }
    
    public function nextStep()
    {
        if ($this->currentStep < $this->maxSteps) {
            $this->currentStep++;

            // Dispatch step changed event for JavaScript
            $this->dispatch('stepChanged', step: $this->currentStep);
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;

            // Dispatch step changed event for JavaScript
            $this->dispatch('stepChanged', step: $this->currentStep);
        }
    }
    
    // Set Current Step
    public function setStep($step)
    {
        $this->currentStep = $step;
    }
    
    public function goToHome()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";
        session()->forget($sessionKey);
        session()->forget('propertyRegistration');
        
        return $this->redirect(route('home'), navigate: true);
    }

    public function render()
    {
        return view('livewire.properties.property-registration');
    }
}
