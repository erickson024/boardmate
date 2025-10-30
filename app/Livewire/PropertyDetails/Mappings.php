<?php

namespace App\Livewire\PropertyDetails;

use Livewire\Component;

class Mappings extends Component
{
    public $destination;
    public $lat;
    public $lng;

    public function mount($lat = null, $lng = null, $destination = null)
    {
        // Default to Manila if no coordinates are passed
        $this->lat = $lat ?? 14.5995;
        $this->lng = $lng ?? 120.9842;
        $this->destination = $destination ?? 'Property Location';
    }

    public function render()
    {
        return view('livewire.property-details.mappings');
    }
}
