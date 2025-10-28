<?php

namespace App\Livewire\PropertyDetails;

use Livewire\Component;
use App\Models\Property;

class Overview extends Component
{
    public $propertyId;
    public $property;

    public function mount($propertyId)
    {
        $this->propertyId = $propertyId;
        $this->property = Property::findOrFail($propertyId);
    }

    public function render()
    {
        return view('livewire.property-details.overview');
    }
}
