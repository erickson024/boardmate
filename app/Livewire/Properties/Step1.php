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
        $sessionKey = "property_reg_{$user_id}";
        
         // Prefill fields if data already exists in session
        $this->fill(session()->get($sessionKey, []));
    }

    public function submit()
    {
        $this->validate();

        // ✅ Always start with this pattern
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";
        $data = session()->get($sessionKey, []);

         // Merge Step 1 data with previous session data
        $data = array_merge($data, [
            'name' => $this->name,
            'cost' => $this->cost,
            'type' => $this->type,
            'description' => $this->description,
        ]);

        // Save merged data back to session
        session()->put($sessionKey, $data);

        $this->dispatch('goToStep', 2);
    }
    public function render()
    {
        return view('livewire.properties.step1');
    }
}
