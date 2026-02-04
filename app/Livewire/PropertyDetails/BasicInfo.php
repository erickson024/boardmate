<?php

namespace App\Livewire\PropertyDetails;

use Livewire\Component;
use App\Models\Property;

class BasicInfo extends Component
{
    public Property $property;

    public function backHome()
    {
        return $this->redirect(route('home'), navigate: true);
    }

    public function inquire()
    {
        // Check if user is logged in
        if (!auth()->check()) {
            session()->flash('error', 'Please login to send an inquiry');
            return redirect()->route('login');
        }

        // Dispatch event to open the inquiry modal
        $this->dispatch('openInquiryModal', propertyId: $this->property->id);
    }

    public function render()
    {
        return view('livewire.property-details.basic-info');
    }
}