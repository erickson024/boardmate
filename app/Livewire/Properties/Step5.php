<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step5 extends Component
{
        public function submit()
    {
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
