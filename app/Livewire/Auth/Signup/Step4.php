<?php

namespace App\Livewire\Auth\Signup;

use Livewire\Component;

class Step4 extends Component
{
    public function submit(){
       
    }

    public function back()
    {
        $this->dispatch('goToStep', 3);
    }

    public function render()
    {
        return view('livewire.auth.signup.step4');
    }
}
