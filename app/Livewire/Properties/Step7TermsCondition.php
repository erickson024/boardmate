<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class Step7TermsCondition extends Component
{
    public string $terms = '';

    protected $listeners = [
        'submitProperty',
    ];

    protected $rules = [
        'terms' => 'required|string|max:5000',
    ];

    public function mount()
    {
        $userId = Auth::id();
        $sessionKey = "property_reg_{$userId}";

        // Load previously saved data from session
        $this->fill(
            data_get(session($sessionKey), 'step7', [])
        );
    }

    public function submitProperty()
    {
        $this->validate();

        $userId = Auth::id();
        $sessionKey = "property_reg_{$userId}";

        /*
        |--------------------------------------------------------------------------
        | Merge step7 into session
        |--------------------------------------------------------------------------
        */
        $allData = array_merge(session()->get($sessionKey, []), [
            'step7' => [
                'terms' => $this->terms,
            ],
        ]);

        session()->put($sessionKey, $allData);

        /*
        |--------------------------------------------------------------------------
        | Save to database (OLD STYLE)
        |--------------------------------------------------------------------------
        */
        $property = new Property();

        // Ownership
        $property->user_id = $userId;

        // Step 1
        $property->propertyName        = $allData['step1']['propertyName']        ?? null;
        $property->propertyCost        = $allData['step1']['propertyCost']        ?? null;
        $property->propertyType        = $allData['step1']['propertyType']        ?? null;
        $property->propertyDescription = $allData['step1']['propertyDescription'] ?? null;

        // Step 2
        $property->address   = $allData['step2']['address']   ?? null;
        $property->latitude  = $allData['step2']['latitude']  ?? null;
        $property->longitude = $allData['step2']['longitude'] ?? null;

        // Step 3–5
        $property->propertyFeatures      = $allData['step3']['propertyFeatures']      ?? [];
        $property->propertyRestrictions = $allData['step4']['propertyRestrictions'] ?? null;
        $property->tenantGender         = $allData['step5']['tenantGender']         ?? null;
        $property->tenantType           = $allData['step5']['tenantType']           ?? null;

        // Step 6 (JSON cast handles encoding)
        $property->images = $allData['step6']['images'] ?? [];

        // Step 7
        $property->terms = $allData['step7']['terms'] ?? null;

        $property->save();

        /*
        |--------------------------------------------------------------------------
        | Clear session + redirect
        |--------------------------------------------------------------------------
        */
        session()->forget($sessionKey);

        session()->flash('property_registration_success', $property->id);

        return $this->redirect(
            route('property-registration-success'),
            navigate: true
        );
    }

    public function back()
    {
        $this->dispatch('goToStep', 6);
    }

    public function render()
    {
        return view('livewire.properties.step7-terms-condition');
    }
}
