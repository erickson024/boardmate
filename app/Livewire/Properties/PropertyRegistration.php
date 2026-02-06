<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\Attributes\On;

class PropertyRegistration extends Component
{
    public $currentStep = 1;
    public $maxSteps = 7;

    public function mount()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";
        $savedData = session()->get($sessionKey);

        if ($savedData && isset($savedData['current_step'])) {
            $this->currentStep = $savedData['current_step'];
        }
    }

    public function continueStep()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        $allData = session()->get($sessionKey, []);
        $data = $allData["step{$this->currentStep}"] ?? [];

        $rules = $this->getStepValidationRules($this->currentStep);

        try {
            $validator = validator($data, $rules);

            if ($validator->fails()) {
                // Dispatch errors to the child component
                $this->dispatch(
                    'validationErrors',
                    step: $this->currentStep,
                    errors: $validator->errors()->toArray()
                );
                return;
            }

            $this->nextStep();
        } catch (\Exception $e) {
            $this->addError('validation', 'Please complete all required fields.');
        }
    }

    private function getStepValidationRules(int $step): array
    {
        return match ($step) {
            1 => [
                'propertyName' => 'required|string|max:255',
                'propertyCost' => 'required|numeric|min:0',
                'propertyType' => 'required|string|in:apartment,condominium,house,studio,dormitory,bedspace',
                'propertyDescription' => 'required|string|max:5000'
            ],
            2 => [
                'address' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ],
            3 => [
                'propertyFeatures' => 'required|array|min:1',
            ],
            4 => [
                'propertyRestrictions' => 'required|array|min:1',
            ],
            5 => [
                'tenantGender' => 'required|string|in:male,female,all',
                'tenantType' => 'required|string|in:student,employee,family,single,2person,groups,couple,all',
            ],
            6 => [
                'images' => 'required|array|min:1|max:5',
            ],
            7 => [
                'terms' => 'required|string|max:5000',
            ],
            default => [],
        };
    }

    public function nextStep()
    {
        if ($this->currentStep < $this->maxSteps) {
            $this->currentStep++;

            $user_id = auth()->id();
            $sessionKey = "property_reg_{$user_id}";

            $allData = session()->get($sessionKey, []);
            $allData['current_step'] = $this->currentStep;
            session()->put($sessionKey, $allData);

            $this->dispatch('stepChanged', step: $this->currentStep);
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;

            $user_id = auth()->id();
            $sessionKey = "property_reg_{$user_id}";

            $allData = session()->get($sessionKey, []);
            $allData['current_step'] = $this->currentStep;
            session()->put($sessionKey, $allData);

            $this->dispatch('stepChanged', step: $this->currentStep);
        }
    }

    public function goToHome()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";
        session()->forget([$sessionKey, 'propertyRegistration']);

        return $this->redirect(route('home'), navigate: true);
    }

    public function render()
    {
        return view('livewire.properties.property-registration');
    }
}
