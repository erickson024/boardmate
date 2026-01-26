<?php

namespace App\Livewire\PropertyDetails;

use Livewire\Component;
use App\Models\Property;

class BasicInfo extends Component
{
    public Property $property;
    public function backHome()
    {
        return $this->redirect(route('home'), navigate: true); // change if your home route name differs
    }

    public function render()
    {
        return view('livewire.property-details.basic-info');
    }
}
