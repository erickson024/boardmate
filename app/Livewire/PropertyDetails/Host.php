<?php

namespace App\Livewire\PropertyDetails;

use Livewire\Component;
use App\Models\Property;

class Host extends Component
{
    public $property;
    public $host;

    public function mount($propertyId)
    {
        $this->property = Property::with('user')->findOrFail($propertyId);
        $this->host = $this->property->user;
    }

    public function render()
    {
        return view('livewire.property-details.host');
    }
}
