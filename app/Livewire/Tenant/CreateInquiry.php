<?php

namespace App\Livewire\Tenant;

use App\Models\Property;
use App\Models\Inquiry;
use App\Models\InquiryMessage;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\InquiryReceived;

class CreateInquiry extends Component
{
    public Property $property;
    public $subject;
    public $message;
    public $existingInquiry = null;

    protected $rules = [
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
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
        $this->validate();

        // Check for existing inquiry
        $existingInquiry = Inquiry::where('property_id', $this->property->id)
            ->where('tenant_id', Auth::id())
            ->first();

        if ($existingInquiry) {
            session()->flash('error', 'You have already sent an inquiry for this property.');
            return redirect()->route('tenant.inquiries');
        }

        // Create inquiry
        $inquiry = Inquiry::create([
            'property_id' => $this->property->id,
            'tenant_id' => Auth::id(),
            'host_id' => $this->property->user_id,
            'subject' => $this->subject,
            'status' => 'pending',
            'read_by_host' => false,
        ]);

        // Create first message
        InquiryMessage::create([
            'inquiry_id' => $inquiry->id,
            'sender_id' => Auth::id(),
            'sender_type' => 'tenant',
            'message' => $this->message,
        ]);

        // 🔔 Notify host
        $inquiry->host->notify(new InquiryReceived($inquiry));

        session()->flash('success', 'Inquiry sent successfully!');
        return redirect()->route('tenant.inquiries');
    }

    public function render()
    {
        return view('livewire.tenant.create-inquiry');
    }
}
