<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property; 

class Properties extends Component
{
    public $properties;

    public function mount()
    {
        $this->properties = Property::latest()->get();
    }

    public function render()
    {
        return view('livewire.properties');
    }
}
