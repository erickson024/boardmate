<?php

namespace App\Livewire\Tenant;

use App\Models\Property;
use App\Models\Inquiry;
use App\Models\InquiryMessage;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateInquiry extends Component
{
    public Property $property;
    public $subject;
    public $message;
    public $existingInquiry = null;

    protected $rules = [
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10',
    ];

    public function mount(Property $property)
    {
        $this->property = $property;
        $this->subject = "Inquiry about {$property->propertyName}";

        // Check if tenant already has an inquiry for this property
        $this->existingInquiry = Inquiry::where('tenant_id', Auth::id())
            ->where('property_id', $property->id)
            ->first();
    }

    public function submit()
    {
        // Double-check they don't already have an inquiry
        if ($this->existingInquiry) {
            session()->flash('error', 'You already have an inquiry for this property.');
            return redirect()->route('tenant.inquiry.chat', $this->existingInquiry);
        }

        $this->validate();

        // Use transaction to ensure both inquiry and message are created
        DB::transaction(function () {
            // Create the inquiry (WITHOUT message field)
            $inquiry = Inquiry::create([
                'property_id' => $this->property->id,
                'tenant_id' => Auth::id(),
                'host_id' => $this->property->user_id,
                'subject' => $this->subject,
                // REMOVED: 'message' => $this->message,
                'status' => 'pending',
            ]);

            // Create the first message in inquiry_messages table
            InquiryMessage::create([
                'inquiry_id' => $inquiry->id,
                'sender_id' => Auth::id(),
                'sender_type' => 'tenant',
                'message' => $this->message,
            ]);

            session()->flash('success', 'Inquiry sent successfully!');
            
            // Redirect to the chat page
            $this->redirect(route('tenant.inquiry.chat', $inquiry->id));
        });
    }

    public function render()
    {
        return view('livewire.tenant.create-inquiry');
    }
}