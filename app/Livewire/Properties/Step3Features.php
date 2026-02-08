<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

class Step3Features extends Component
{
    #[Validate('required|array|min:1')]
    public array $propertyFeatures = [];

    private string $sessionKey;

    public function boot()
    {
        $this->sessionKey = "property_reg_" . auth()->id();
    }

    public function mount()
    {
        // FIX: Same pattern as other steps
        $allData = session()->get($this->sessionKey, []);
        $step3Data = $allData['step3'] ?? [];
        $this->propertyFeatures = $step3Data['propertyFeatures'] ?? [];
    }

    // ADD: Auto-save on every update (same pattern as Step1)
    public function updated($name, $value)
    {
        // Validate only the field that changed
        $this->validateOnly($name);

        // Save to session
        $this->saveToSession();
    }

    #[On('validationErrors')]
    public function handleValidationErrors($step, $errors)
    {
        // Only handle errors for this step
        if ($step !== 3) return;

        // Add errors to this component
        foreach ($errors as $field => $messages) {
            $this->addError($field, is_array($messages) ? $messages[0] : $messages);
        }
    }

    private function saveToSession(): void
    {
        // FIX: Same pattern as other steps
        $allData = session()->get($this->sessionKey, []);
        
        $allData['step3'] = [
            'propertyFeatures' => $this->propertyFeatures
        ];
        
        session()->put($this->sessionKey, $allData);
    }

    public function render()
    {
        return view('livewire.properties.step3-features', [
            'propertyFeatureIcons' => config('property-features.icons'),
            'featureColors' => config('property-features.colors'),
        ]);
    }
}