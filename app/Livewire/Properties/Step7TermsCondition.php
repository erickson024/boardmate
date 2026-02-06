<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Property;


class Step7TermsCondition extends Component
{
    public string $terms = '';

    private string $sessionKey;

    public function boot()
    {
        $this->sessionKey = "property_reg_" . auth()->id();
    }

    public function mount()
    {
        // FIX: Get all data first, then access step7
        $allData = session()->get($this->sessionKey, []);
        $step7Data = $allData['step7'] ?? [];
        $this->terms = $step7Data['terms'] ?? '';
    }

    public function updatedTerms()
    {
        $this->saveToSession();
    }

    private function saveToSession(): void
    {
        // FIX: Get all data, update step7, save back
        $allData = session()->get($this->sessionKey, []);
        
        $allData['step7'] = [
            'terms' => $this->terms,
        ];
        
        session()->put($this->sessionKey, $allData);
    }

    #[On('submitProperty')]
    public function submitProperty()
    {
        $userId = auth()->id();
        $allData = session()->get($this->sessionKey, []);

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
            'terms' => $allData['step7']['terms'] ?? null,
        ]);

        session()->forget($this->sessionKey);
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