<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class PropertyRegistrationButton extends Component
{
    public $hasDraft = false;

    public function mount()
    {
        $this->checkDraft();
    }

    #[On('draft-status-changed')]
    public function checkDraft()
    {
        $this->hasDraft = session()->has('property_draft_status_' . auth()->id());
    }

    public function render()
    {
        return view('livewire.property-registration-button');
    }
}