<?php

namespace App\Livewire\Users\Dashboard;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class PropertyList extends Component
{
    use WithPagination;

    public $propertyName = '';
    public $propertyCost = '';
    public $location = '';
    public $propertyType = '';
    public $tenantType = '';
    public $tenantGender = '';
    public $perPage = 12;

    protected $paginationTheme = 'bootstrap';

    #[On('filtersUpdated')]
    public function updateFilters($filters)
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
        $properties = Property::where('user_id', auth()->id())
            ->when($this->propertyName, function($query) {
                $query->where('propertyName', 'like', '%' . $this->propertyName . '%');
            })
            ->when($this->location, function($query) {
                $query->where('address', 'like', '%' . $this->location . '%');
            })
            ->when($this->propertyType, function($query) {
                $query->where('propertyType', $this->propertyType);
            })
            ->when($this->tenantType, function($query) {
                $query->where('tenantType', $this->tenantType);
            })
            ->when($this->tenantGender, function($query) {
                $query->where('tenantGender', $this->tenantGender);
            })
            ->when($this->propertyCost, function($query) {
                $query->where('propertyCost', '<=', $this->propertyCost);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.users.dashboard.property-list', [
            'properties' => $properties
        ]);
    }
}