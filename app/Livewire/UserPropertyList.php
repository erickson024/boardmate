<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;

class UserPropertyList extends Component
{

    public $properties;
    public $propertyToDelete;

    // Load properties when the component mounts
    public function mount($colSize = 'col-3')
    {
        $this->colSize = $colSize;
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

        session()->flash('success', 'Property deleted successfully!');

        // Redirect with Livewire's SPA-style navigation
        return $this->redirect('/profile', navigate: true);
    }

    public $colSize = 'col-12';



    public function render()
    {
        return view('livewire.user-property-list');
    }
}
