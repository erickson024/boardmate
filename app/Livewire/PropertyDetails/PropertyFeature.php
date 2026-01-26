<?php

namespace App\Livewire\PropertyDetails;

use Livewire\Component;
use App\Models\Property;

class PropertyFeature extends Component
{
    public Property $property;

    public array $propertyFeatureIcons;
    public array $featureColors;

    public function mount()
    {
        $this->propertyFeatureIcons = config('property-features.icons');
        $this->featureColors = config('property-features.colors');
    }

    public function render()
    {
        return view('livewire.property-details.property-feature');
    }
}
