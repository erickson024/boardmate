<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Register extends Component
{
    public $strengthScore;
    public function render()
    {
        return view('livewire.auth.register');
    }
}
