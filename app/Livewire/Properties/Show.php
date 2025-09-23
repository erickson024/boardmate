<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use App\Models\Property;

class Show extends Component
{
    public $property;
    public $images = [];

    public function mount($id)
    {
        $this->property = Property::findOrFail($id);
        $this->images = json_decode($this->property->images, true) ?? [];
    }

    public function render()
    {
        return view('livewire.properties.show');
    }
}
