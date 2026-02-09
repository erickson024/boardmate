<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use App\Models\Property;
use App\Notifications\PropertyCreated; // ADD THIS

class Step7TermsCondition extends Component
{
    #[Validate('required|string|max:2000')]
    public string $terms = '';

    private string $sessionKey;

    public function boot()
    {
        $this->sessionKey = "property_reg_" . auth()->id();
    }

    public function mount()
    {
        $allData = session()->get($this->sessionKey, []);
        $step7Data = $allData['step7'] ?? [];
        $this->terms = $step7Data['terms'] ?? '';
    }

    public function updated($name, $value)
    {
        $this->validateOnly($name);
        $this->saveToSession();
    }

    #[On('validationErrors')]
    public function handleValidationErrors($step, $errors)
    {
        if ($step !== 7) return;

        foreach ($errors as $field => $messages) {
            $this->addError($field, is_array($messages) ? $messages[0] : $messages);
        }
    }

    private function saveToSession(): void
    {
        $allData = session()->get($this->sessionKey, []);

        $allData['step7'] = [
            'terms' => $this->terms,
        ];

        session()->put($this->sessionKey, $allData);
    }

    #[On('submitProperty')]
    public function submitProperty()
    {
        // Save current state before submitting
        $this->saveToSession();

        $userId = auth()->id();
        $allData = session()->get($this->sessionKey, []);

        // Validate before creating property
        if (empty($allData['step7']['terms'])) {
            $this->addError('terms', 'Terms and conditions are required.');
            $this->dispatch('validationFailed', step: 7);
            return;
        }

        $property = Property::create([
            'user_id' => $userId,
            'propertyName' => $allData['step1']['propertyName'] ?? null,
            'propertyCost' => $allData['step1']['propertyCost'] ?? null,
            'propertyType' => $allData['step1']['propertyType'] ?? null,
            'propertyDescription' => $allData['step1']['propertyDescription'] ?? null,
            'address' => $allData['step2']['address'] ?? null,
            'latitude' => $allData['step2']['latitude'] ?? null,
            'longitude' => $allData['step2']['longitude'] ?? null,
            'propertyFeatures' => $allData['step3']['propertyFeatures'] ?? [],
            'propertyRestrictions' => $allData['step4']['propertyRestrictions'] ?? [],
            'tenantGender' => $allData['step5']['tenantGender'] ?? null,
            'tenantType' => $allData['step5']['tenantType'] ?? null,
            'images' => $allData['step6']['images'] ?? [],
            'terms' => $allData['step7']['terms'],
        ]);

        // Send notification to the host
        auth()->user()->notify(new PropertyCreated($property));

        // ✅ CLEAR BOTH SESSION KEYS
        session()->forget($this->sessionKey);
        session()->forget('property_draft_status_' . $userId); // ADD THIS LINE

        // ✅ DISPATCH EVENT TO UPDATE THE BADGE
        $this->dispatch('draft-status-changed'); // ADD THIS LINE

        session()->flash('property_registration_success', $property->id);

        return $this->redirect(
            route('user.dashboard', ['currentTab' => 'property-list']),
            navigate: true
        );
    }

    public function render()
    {
        return view('livewire.properties.step7-terms-condition');
    }
}