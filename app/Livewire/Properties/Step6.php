<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step6 extends Component
{
    public $terms, $payment, $agree;

    protected $rules = [
        'terms' => 'nullable|string|max:255',
        'payment' => 'nullable|string|max:255',
        'agree' => 'accepted',
    ];

    public function mount()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        // Load previously saved data from session
        $this->fill(
            data_get(session($sessionKey), 'policies', [])
        );
    }

    public function submit()
    {
        $this->validate();

        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

         // Merge with all previous session data
        $allData = array_merge(session()->get($sessionKey, []), [
            'policies' => [
                'terms' => $this->terms,
                'payment' => $this->payment,
                'agree' => $this->agree,
            ],
        ]);

        // Save back to session under unified key
        session()->put($sessionKey, $allData);
        dd(session());
    }
  
    public function back()
    {
        $this->dispatch('goToStep', 5);
    }
    public function render()
    {
        return view('livewire.properties.step6');
    }
}
