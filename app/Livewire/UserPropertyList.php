<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;

class UserPropertyList extends Component
{

    public $properties;
    public $propertyToDelete;

    // Load properties when the component mounts
    public function mount()
    {
        $this->loadProperties();
    }

    public function loadProperties()
    {
        $this->properties = Property::where('user_id', auth()->id())
            ->latest()
            ->get();
    }


    public function deleteProperty($id)
{
    $property = Property::where('user_id', auth()->id())->findOrFail($id);
    $property->delete();

    session()->flash('success', 'Property successfully deleted.');

    $this->loadProperties(); // refresh the list
}

    public function render()
    {
        return view('livewire.user-property-list');
    }
}
