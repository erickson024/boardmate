<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Property;

class PropertyList extends Component
{
    use WithPagination;

    public $term = '';
    public $cost = '';
    public $address = '';
    public $type = '';

    protected $paginationTheme = 'bootstrap'; // ✅ Add this


    public function updating($field)
    {
        if (in_array($field, ['term', 'cost', 'location', 'type'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $properties = Property::query()
            ->when(
                $this->term,
                fn($q) =>
                $q->where('name', 'like', '%' . $this->term . '%')
            )
            ->when(
                $this->cost,
                fn($q) =>
                $q->where('cost', '<=', $this->cost)
            )
            ->when(
                $this->address,
                fn($q) =>
                $q->where('address', 'like', '%' . $this->address . '%')
            )
            ->when(
                $this->type,
                fn($q) =>
                $q->where('type','like','%' . $this->type)
            )

            ->paginate(12);

        return view('livewire.properties.property-list', [
            'properties' => $properties,
        ]);
    }
}
