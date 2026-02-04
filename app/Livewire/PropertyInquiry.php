<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Inquiry;
use App\Models\Property;

class PropertyInquiry extends Component
{
    public $property;
    public $message = '';
    public $preferredVisitDate = '';

    protected $rules = [
        'message' => 'nullable|string|max:1000',
        'preferredVisitDate' => 'required|date|after:today', // Make it required
    ];

    protected $messages = [
        'preferredVisitDate.required' => 'Please select your preferred visit date and time.',
        'preferredVisitDate.after' => 'The visit date must be in the future.',
    ];

    public function mount($propertyId)
    {
        $this->property = Property::with('user')->findOrFail($propertyId);
        
        // Redirect if not authenticated
        if (!auth()->check()) {
            session()->flash('error', 'Please login to send an inquiry');
            return redirect()->route('login');
        }

        // Check if user is trying to inquire about their own property
        if ($this->property->user_id === auth()->id()) {
            session()->flash('error', 'You cannot inquire about your own property');
            return redirect()->route('property.details', $propertyId);
        }

        // Check if already has a pending inquiry
        $existingInquiry = Inquiry::where('user_id', auth()->id())
            ->where('property_id', $this->property->id)
            ->whereIn('status', ['pending', 'accepted']) // Check both pending and accepted
            ->first();

        if ($existingInquiry) {
            if ($existingInquiry->status === 'pending') {
                session()->flash('info', 'You already have a pending inquiry for this property');
            } else {
                session()->flash('info', 'You already have an accepted inquiry for this property');
            }
            return redirect()->route('tenant.inquiries');
        }
    }

    public function submitInquiry()
    {
        $this->validate();

        // Double-check for existing inquiry
        $existingInquiry = Inquiry::where('user_id', auth()->id())
            ->where('property_id', $this->property->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->first();

        if ($existingInquiry) {
            session()->flash('error', 'You already have an inquiry for this property');
            return redirect()->route('tenant.inquiries');
        }

        Inquiry::create([
            'user_id' => auth()->id(),
            'property_id' => $this->property->id,
            'host_id' => $this->property->user_id,
            'message' => $this->message,
            'preferred_visit_date' => $this->preferredVisitDate,
            'status' => 'pending',
        ]);

        session()->flash('success', 'Your inquiry has been sent successfully! The host will respond soon.');
        return redirect()->route('tenant.inquiries');
    }

    public function cancel()
    {
        return $this->redirect(route('property.details', $this->property->id), navigate:true);
    }

    public function render()
    {
        return view('livewire.property-inquiry');
    }
}