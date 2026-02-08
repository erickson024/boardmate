<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\Attributes\On;

class PropertyRegistration extends Component
{
    public $currentStep = 1;
    public $maxSteps = 7;
    public $hasExistingData = false; // ADD THIS
    
    private string $sessionKey;
    private string $draftStatusKey;

    public function boot()
    {
        $this->sessionKey = "property_reg_" . auth()->id();
        $this->draftStatusKey = "property_draft_status_" . auth()->id();
    }

    public function mount()
    {
        $savedData = session()->get($this->sessionKey);

        if ($savedData && isset($savedData['current_step'])) {
            $this->currentStep = $savedData['current_step'];
        }
        
        // Check if there's actual data to save
        $this->checkExistingData();
    }

    // ADD: Check if there's any meaningful data in the session
    private function checkExistingData()
    {
        $allData = session()->get($this->sessionKey, []);
        
        // Remove 'current_step' from check
        unset($allData['current_step']);
        
        // Check if any step has data
        $hasData = false;
        foreach ($allData as $stepKey => $stepData) {
            if (!empty($stepData)) {
                $hasData = true;
                break;
            }
        }
        
        $this->hasExistingData = $hasData;
    }

    // ADD: Update check after each step
    public function nextStep()
    {
        if ($this->currentStep < $this->maxSteps) {
            $this->currentStep++;

            $allData = session()->get($this->sessionKey, []);
            $allData['current_step'] = $this->currentStep;
            session()->put($this->sessionKey, $allData);

            $this->checkExistingData(); // ADD THIS
            $this->dispatch('stepChanged', step: $this->currentStep);
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;

            $allData = session()->get($this->sessionKey, []);
            $allData['current_step'] = $this->currentStep;
            session()->put($this->sessionKey, $allData);

            $this->dispatch('stepChanged', step: $this->currentStep);
        }
    }

    public function continueStep()
    {
        $allData = session()->get($this->sessionKey, []);
        $data = $allData["step{$this->currentStep}"] ?? [];

        $rules = $this->getStepValidationRules($this->currentStep);

        try {
            $validator = validator($data, $rules);

            if ($validator->fails()) {
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

    // UPDATED: Keep draft only if there's data
    public function keepDraftAndExit()
    {
        $this->checkExistingData();
        
        if (!$this->hasExistingData) {
            session()->flash('error', 'No data to save. Please fill out at least one field.');
            return;
        }
        
        session()->put($this->draftStatusKey, true);
        $this->dispatch('draft-status-changed');
        session()->flash('message', 'Draft saved! You can continue later.');
        
        return $this->redirect(route('home'), navigate: true);
    }

    // UPDATED: Always allow delete (even if no data)
    public function deleteDraftAndExit()
    {
        session()->forget([$this->sessionKey, $this->draftStatusKey]);
        $this->dispatch('draft-status-changed');
        session()->flash('message', 'Registration cancelled.');
        
        return $this->redirect(route('home'), navigate: true);
    }

    public function goToHome()
    {
        session()->forget([$this->sessionKey, $this->draftStatusKey]);
        return $this->redirect(route('home'), navigate: true);
    }

    public function render()
    {
        return view('livewire.properties.property-registration');
    }
}