<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

class Step4Restriction extends Component
{
    #[Validate('required|array|min:1')]
    public array $propertyRestrictions = [];

    private string $sessionKey;

    public function boot()
    {
        $this->sessionKey = "property_reg_" . auth()->id();
    }

    public function mount()
    {
        // FIX: Same pattern as other steps
        $allData = session()->get($this->sessionKey, []);
        $step4Data = $allData['step4'] ?? [];
        $this->propertyRestrictions = $step4Data['propertyRestrictions'] ?? [];
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
        if ($step !== 4) return;

        // Add errors to this component
        foreach ($errors as $field => $messages) {
            $this->addError($field, is_array($messages) ? $messages[0] : $messages);
        }
    }

    private function saveToSession(): void
    {
        // FIX: Same pattern as other steps
        $allData = session()->get($this->sessionKey, []);
        
        $allData['step4'] = [
            'propertyRestrictions' => $this->propertyRestrictions
        ];
        
        session()->put($this->sessionKey, $allData);
    }

    public function render()
    {
        return view('livewire.properties.step4-restriction', [
            'propertyRestrictionIcons' => config('property-restriction.propertyRestrictionIcons'),
        ]);
    }
}