<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Indicator extends Component
{
    public $currentStep;
    public $totalSteps;

    protected $listeners = ['stepChanged' => 'updateStep'];

    public function updateStep($step)
    {
        $this->currentStep = $step;
    }


    public function render()
    {
        return view('livewire.auth.indicator');
    }
}
