<?php

namespace App\Livewire\PropertyDetails;

use Livewire\Component;
use App\Models\Property;

class TenantInfo extends Component
{
    public Property $property;

    public function render()
    {
        return view('livewire.property-details.tenant-info');
    }
}
