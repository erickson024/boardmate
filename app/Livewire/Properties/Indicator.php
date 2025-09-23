<?php

namespace App\Livewire\Properties;

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
        return view('livewire.properties.indicator');
    }
}
