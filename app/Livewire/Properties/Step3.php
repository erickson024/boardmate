<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step3 extends Component
{
    public $feature = [];

    public function mount()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        // Load existing data safely
        $data = session()->get($sessionKey, []);
        $this->feature = $data['features'] ?? [];
    }

    public function toggleFeature($label)
    {
        if (in_array($label, $this->feature)) {
            $this->feature = array_values(array_diff($this->feature, [$label]));
        } else {
            $this->feature[] = $label;
        }

        // ✅ Use user-specific session key
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}.features";
        session()->put($sessionKey, $this->feature);
    }

    public function submit()
    {
        $this->saveToSession();
        $this->dispatch('goToStep', 4);
    }

    public function back()
    {
        // ✅ Save before going back
        $this->saveToSession();
        $this->dispatch('goToStep', 2);
    }

    private function saveToSession()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        // Merge existing data with features
        $data = session()->get($sessionKey, []);
        $data['features'] = $this->feature;

        session()->put($sessionKey, $data);
    }

    public function render()
    {
        return view('livewire.properties.step3');
    }
}
