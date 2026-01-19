<?php

namespace App\Livewire\PropertyDetails;

use Livewire\Component;
use App\Models\Property;

class Images extends Component
{
    public Property $property;

    public function mount(Property $property)
    {
        $this->property = $property;
    }


    public function render()
    {
        return view('livewire.property-details.images');
    }
}
