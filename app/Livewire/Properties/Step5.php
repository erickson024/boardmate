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

        // Load previously saved data from session
        $this->fill(
            data_get(session("property_reg{$user_id}"), 'tenant', [])
        );
    }

    public function submit()
    {
        $this->validate();

        $user_id = auth()->id();
        $allData = array_merge(session()->get("property_reg{$user_id}", []), [
            'tenant' => [
                'tenantType' => $this->tenantType,
                'tenantGender' => $this->tenantGender,
                'tenantRestriction' => $this->tenantRestriction,
            ]
        ]);

        session()->put("property_reg{$user_id}", $allData);
        dd(session());


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
