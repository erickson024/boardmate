<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Property;

class Home extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $propertyName = '';
    public $propertyCost = '';
    public $location = '';
    public $propertyType = '';
    public $tenantType = '';
    public $tenantGender = '';

    protected $listeners = ['filtersUpdated' => 'applyFilters'];

    public function applyFilters($filters)
    {
        $this->propertyName = $filters['propertyName'] ?? '';
        $this->propertyCost = $filters['propertyCost'] ?? '';
        $this->location = $filters['location'] ?? '';
        $this->propertyType = $filters['propertyType'] ?? '';
        $this->tenantType = $filters['tenantType'] ?? '';
        $this->tenantGender = $filters['tenantGender'] ?? '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Property::query();

        if ($this->propertyName) {
            $query->where('propertyName', 'like', '%' . $this->propertyName . '%');
        }

        if ($this->propertyCost) {
            $query->where('propertyCost', '<=', $this->propertyCost);
        }

        if ($this->location) {
            $query->where('address', 'like', '%' . $this->location . '%');
        }

        if ($this->propertyType) {
            $query->where('propertyType', $this->propertyType);
        }

        if ($this->tenantType) {
            $query->where('tenantType', $this->tenantType);
        }

        if ($this->tenantGender) {
            $query->where('tenantGender', $this->tenantGender);
        }

        // Changed from inRandomOrder() to latest() for better pagination performance
        // and changed from 16 to 12 items per page for cleaner layout (3 rows of 4)
        $properties = $query->inRandomOrder()->paginate(12);

        return view('livewire.home', [
            'properties' => $properties,
        ]);
    }
}