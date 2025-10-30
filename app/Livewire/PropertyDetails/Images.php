<?php

namespace App\Livewire\PropertyDetails;

use Livewire\Component;
use App\Models\Property;

class Images extends Component
{
    public $propertyId;
    public $property;
    public $images = [];
    public $activeIndex = 0;
    public $showThumbnails = true;

    protected $listeners = [
        'updateActiveIndex' => 'setActiveSlide'
    ];

    public function mount($propertyId)
    {
        $this->propertyId = $propertyId;
        $this->property = Property::findOrFail($propertyId);
        $this->images = json_decode($this->property->images, true) ?? [];
    }

    public function toggleThumbnails()
    {
        $this->showThumbnails = !$this->showThumbnails;
    }

    public function setActiveSlide($index)
    {
        $this->activeIndex = $index;
        $this->dispatch('goToSlide', index: $index);
    }

    public function render()
    {
        return view('livewire.property-details.images');
    }
}
