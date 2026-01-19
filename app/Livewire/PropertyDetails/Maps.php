<?php

namespace App\Livewire\PropertyDetails;

use Livewire\Component;
use App\Models\Property;

class Maps extends Component
{
    public Property $property;

    public function mount(Property $property)
    {
        $this->property = $property;

        $this->dispatch('init-map', [
            'address' => $this->property->address,
            'name' => $this->property->propertyName,
        ]);
    }

    public function render()
    {
        return view('livewire.property-details.maps');
    }
}
