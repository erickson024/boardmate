<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use App\Models\Property;

class RegistrationSuccess extends Component
{
    public Property $property;

    public function mount()
    {
        $propertyId = session('property_registration_success');

        $this->property = Property::findOrFail($propertyId);
        
        //redirect if the ID is null
        if (! $propertyId) {
            return redirect()->route('property-registration');
        }
    }

    public function render()
    {
        return view('livewire.properties.registration-success');
    }
}
