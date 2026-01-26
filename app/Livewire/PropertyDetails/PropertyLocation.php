<?php

namespace App\Livewire\PropertyDetails;
use App\Models\Property;

use Livewire\Component;

class PropertyLocation extends Component
{
    public Property $property;
    
    public function render()
    {
        return view('livewire.property-details.property-location');
    }
}
