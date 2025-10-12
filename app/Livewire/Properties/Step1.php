<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step1 extends Component
{
    public $name, $cost, $type = "Apartment", $description;

    protected $rules = [
        'name' => 'required|string|max:50',
        'cost' => 'required|numeric',
        'type' => 'required|string|max:50',
        'description' => 'required|string|max:255'
    ];

    public function mount()
    {
        $user_id = auth()->id();
        $this->fill(session()->get("property_reg_{$user_id}", []));
    }

    public function submit()
    {
        $this->validate();

        $user_id = auth()->id(); // or however you identify the current user

        $registrationData = session()->get("property_reg_{$user_id}", []);
        $registrationData = array_merge($registrationData, [
            'name' => $this->name,
            'cost' => $this->cost,
            'type' => $this->type,
            'description' => $this->description,
        ]);

        session()->put("property_reg_{$user_id}", $registrationData);

        $this->dispatch('goToStep', 2);
    }
    public function render()
    {
        return view('livewire.properties.step1');
    }
}
