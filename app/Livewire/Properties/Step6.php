<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step6 extends Component
{

 

    public function back()
    {
        $this->dispatch('goToStep', 5);
    }
    public function render()
    {
        return view('livewire.properties.step6');
    }
}
