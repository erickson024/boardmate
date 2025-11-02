<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Property;

class Properties extends Component
{
   use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $propertyName = '';
    public $costCap = '';
    public $location = '';
    public $propertyType = '';

    protected $listeners = ['filtersUpdated' => 'applyFilters'];

    public function applyFilters($filters)
    {
        $this->propertyName = $filters['propertyName'];
        $this->costCap = $filters['costCap'];
        $this->location = $filters['location'];
        $this->propertyType = $filters['propertyType'];
        $this->resetPage();
    }

    public function render()
    {
        $query = Property::query();

        if ($this->propertyName) {
            $query->where('name', 'like', '%' . $this->propertyName . '%');
        }

        if ($this->costCap) {
            $query->where('cost', '<=', $this->costCap);
        }

        if ($this->location) {
            $query->where('address', 'like', '%' . $this->location . '%');
        }

        if ($this->propertyType) {
            $query->where('type', $this->propertyType);
        }

        $properties = $query->inRandomOrder()->paginate(16);

        return view('livewire.properties', [
            'properties' => $properties,
        ]);
    }
}
