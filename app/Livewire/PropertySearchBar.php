<?php

namespace App\Livewire;

use Livewire\Component;

class PropertySearchBar extends Component
{
    public $propertyName = '';
    public $costCap = '';
    public $location = '';
    public $propertyType = '';

    protected $updatesQueryString = ['propertyName', 'costCap', 'location', 'propertyType'];

    public function updated()
    {
        // Emit event to parent (the property list component)
        $this->dispatch('filtersUpdated', [
            'propertyName' => $this->propertyName,
            'costCap' => $this->costCap,
            'location' => $this->location,
            'propertyType' => $this->propertyType,
        ]);
    }


    public function render()
    {
        return view('livewire.property-search-bar');
    }
}
