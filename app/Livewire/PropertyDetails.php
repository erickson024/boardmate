<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;

class PropertyDetails extends Component
{
    public $propertyId;
    public $property;

    public function mount($id)
    {
        $this->propertyId = $id;
        $this->property = Property::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.property-details');
    }
}
