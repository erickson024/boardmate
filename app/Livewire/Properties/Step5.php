<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step5 extends Component
{
    public $tenantType = "Employee", $tenantGender = "Male", $tenantRestriction;

    protected $rules = [
        'tenantType' => 'required|string',
        'tenantGender' => 'required|string',
        'tenantRestriction' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        // Load previously saved data from session
        $this->fill(
            data_get(session($sessionKey), 'tenant', [])
        );
    }

    public function submit()
    {
        $this->validate();

        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        // Merge with all previous session data
        $allData = array_merge(session()->get($sessionKey, []), [
            'tenant' => [
                'tenantType' => $this->tenantType,
                'tenantGender' => $this->tenantGender,
                'tenantRestriction' => $this->tenantRestriction,
            ],
        ]);

        // Save back to session under unified key
        session()->put($sessionKey, $allData);
        $this->dispatch('goToStep', 6);
    }

    public function back()
    {
        $this->dispatch('goToStep', 4);
    }

    public function render()
    {
        return view('livewire.properties.step5');
    }
}
