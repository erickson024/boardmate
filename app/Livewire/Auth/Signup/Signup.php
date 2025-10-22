<?php

namespace App\Livewire\Auth\Signup;

use Livewire\Component;

class Signup extends Component
{
    public $currentStep = 1;

    protected $listeners = [
        'goToStep' => 'setStep',
    ];

    public function setStep($step)
    {
        $this->currentStep = $step;
    }

    public function goToDashboard()
    {
        session()->forget('signup'); // remove signup progress data
        return redirect()->route('landing'); // or 'explore'
    }

    public function render()
    {
        return view('livewire.auth.signup.signup');
    }
}
