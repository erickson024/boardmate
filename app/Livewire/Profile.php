<?php

namespace App\Livewire;

use Livewire\Component;

class Profile extends Component
{
    public $properties;
    public $count;

    public function mount()
    {
        // Get all properties added by the logged-in user
        $this->properties = auth()->user()->properties;

        // Count them
        $this->count = $this->properties->count();
    }

    public function goToPropertyList()
{
    return $this->redirect(route('user-property-list'), navigate: true);
}
    
    public function render()
    {
        return view('livewire.profile', [
            'properties' => $this->properties,
            'count' => $this->count,
        ]);
    }
}
