<?php

namespace App\Livewire\PropertyDetails;

use Livewire\Component;
use App\Models\Property;

class PropertyRestriction extends Component
{
    public Property $property;
    public array $propertyRestrictionIcons = [];

    public function mount(Property $property)
    {
        $this->property = $property;
        $this->propertyRestrictionIcons = config('property-restriction.propertyRestrictionIcons');
    }

    public function render()
    {
        return view('livewire.property-details.property-restriction');
    }
}
