<?php

namespace App\Livewire\PropertyDetails;

use Livewire\Component;
use App\Models\Property;

class Navigator extends Component
{
    public $active = 'overview';
    public $propertyId;
    public $property;

    public function mount($id)
    {
        $this->propertyId = $id;
        $this->property = Property::findOrFail($id);
    }

    public function setTab($tab)
    {
        $this->active = $tab;
        $this->dispatch('tab-changed');
    }

    public function render()
    {
        return view('livewire.property-details.navigator', [
            'property' => $this->property
        ]);
    }
}