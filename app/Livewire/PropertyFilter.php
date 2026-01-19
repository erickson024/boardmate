<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;

class PropertyFilter extends Component
{
    public $propertyName = '';
    public $address = '';
    public $propertyType = '';
    public $tenantType = '';
    public $tenantGender = '';
    public $maxCost = '';

    public function updated()
    {
        $this->dispatch('filtersUpdated', [
            'propertyName' => $this->propertyName,
            'propertyCost' => $this->maxCost,
            'location' => $this->address,
            'propertyType' => $this->propertyType,
            'tenantType' => $this->tenantType,
            'tenantGender' => $this->tenantGender,
        ]);
    }

    public function clearFilters()
    {
        $this->propertyName = '';
        $this->address = '';
        $this->propertyType = '';
        $this->tenantType = '';
        $this->tenantGender = '';
        $this->maxCost = '';

        $this->dispatch('filtersUpdated', [
            'propertyName' => '',
            'propertyCost' => '',
            'location' => '',
            'propertyType' => '',
            'tenantType' => '',
            'tenantGender' => '',
        ]);
    }

    public function render()
    {
        $propertyTypes = Property::distinct()->pluck('propertyType')->filter();
        $tenantTypes = Property::distinct()->pluck('tenantType')->filter();

        return view('livewire.property-filter', [
            'propertyTypes' => $propertyTypes,
            'tenantTypes' => $tenantTypes,
        ]);
    }
}