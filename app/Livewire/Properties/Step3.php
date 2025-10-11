<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step3 extends Component
{
    public $feature = [];

    public function mount()
    {
        // ✅ Load the features from session properly
        $this->feature = session('property_reg.features', []);
    }

    public function toggleFeature($label)
    {
        if (in_array($label, $this->feature)) {
            $this->feature = array_values(array_diff($this->feature, [$label]));
        } else {
            $this->feature[] = $label;
        }

        // ✅ Update session immediately when toggling (prevents losing data when navigating)
        session()->put('property_reg.features', $this->feature);
    }

    public function submit()
    {
        // ✅ No need for duplicate session key names or array merging
        session()->put('property_reg.features', $this->feature);

        $this->dispatch('goToStep', 4);
    }

    public function back()
    {
        // ✅ Save before going back
        session()->put('property_reg.features', $this->feature);
        $this->dispatch('goToStep', 2);
    }

    public function render()
    {
        return view('livewire.properties.step3');
    }
}
