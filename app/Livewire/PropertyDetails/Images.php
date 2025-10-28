<?php

namespace App\Livewire\PropertyDetails;

use Livewire\Component;
use App\Models\Property;

class Images extends Component
{
    public $propertyId;
    public $property;
    public $images = [];

    public function mount($propertyId)
    {
        $this->propertyId = $propertyId;
        $this->property = Property::findOrFail($propertyId);
        $this->images = json_decode($this->property->images, true) ?? [];
    }

    public function render()
    {
        return view('livewire.property-details.images', [
             'property' => $this->property,
            'images' => $this->images,
        ]);
    }
}
