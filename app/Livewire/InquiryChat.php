<?php

namespace App\Livewire;

use App\Models\Inquiry;
use App\Models\InquiryMessage;
use App\Models\PropertyVisit;
use App\Models\LeaseAgreement;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

// Import notifications
use App\Notifications\InquiryAccepted;
use App\Notifications\VisitRequested;
use App\Notifications\VisitConfirmed;
use App\Notifications\LeaseAgreementSent;
use App\Notifications\LeaseAgreementSigned;

class InquiryChat extends Component
{
    public Inquiry $inquiry;
    public $newMessage = '';
    public $userRole;
    public $lastMessageId = 0;
    public $otherUserTyping = false;
    public $currentStatus;
    
    // Visit scheduling properties
    public $showVisitForm = false;
    public $proposedDate;
    public $visitNotes;

    // Lease Agreement properties
    public $showLeaseForm = false;
    public $leaseStartDate;
    public $leaseEndDate;
    public $securityDeposit;
    public $specialConditions;

    protected $rules = [
        'newMessage' => 'required|string|min:1|max:1000',
    ];

    public function mount(Inquiry $inquiry)
    {
        $user = Auth::user();

        if ($user->id !== $inquiry->tenant_id && $user->id !== $inquiry->host_id) {
            abort(403, 'Unauthorized access to this inquiry.');
        }

        $this->inquiry = $inquiry;
        $this->userRole = $user->id === $inquiry->tenant_id ? 'tenant' : 'host';
        $this->currentStatus = $inquiry->status;

        if ($this->userRole === 'host' && !$inquiry->read_by_host) {
            $inquiry->markAsRead();
        }

        $this->markMessagesAsRead();

        $lastMessage = $this->inquiry->messages()->latest()->first();
        if ($lastMessage) {
            $this->lastMessageId = $lastMessage->id;
        }
    }

    public function markMessagesAsRead()
    {
        $this->inquiry->messages()
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function updatedNewMessage()
    {
        Cache::put(
            "inquiry_{$this->inquiry->id}_user_{$this->userRole}_typing",
            true,
            now()->addSeconds(3)
        );
    }

    public function checkForNewMessages()
    {
        $otherUserRole = $this->userRole === 'tenant' ? 'host' : 'tenant';
        $this->otherUserTyping = Cache::get(
            "inquiry_{$this->inquiry->id}_user_{$otherUserRole}_typing",
            false
        );

        // Refresh inquiry WITH visit relationship
        $this->inquiry->load('visit'); // ← ADD THIS LINE
        $this->inquiry->refresh();

        if ($this->currentStatus !== $this->inquiry->status) {
            $this->currentStatus = $this->inquiry->status;
            $this->dispatch('status-changed', status: $this->inquiry->status);
        }

        $latestMessage = $this->inquiry->messages()->latest()->first();

        if ($latestMessage && $latestMessage->id > $this->lastMessageId) {
            $this->lastMessageId = $latestMessage->id;
            $this->markMessagesAsRead();
            $this->dispatch('message-received');
        }
    }

    public function sendMessage()
    {
        if (in_array($this->inquiry->status, ['closed', 'rejected'])) {
            session()->flash('error', 'This conversation is closed.');
            return;
        }

        $this->validate();

        $message = InquiryMessage::create([
            'inquiry_id' => $this->inquiry->id,
            'sender_id' => Auth::id(),
            'sender_type' => $this->userRole,
            'message' => $this->newMessage,
        ]);

        if ($this->userRole === 'host' && $this->inquiry->status === 'pending') {
            $this->inquiry->update(['status' => 'replied']);
            $this->currentStatus = 'replied';
        }

        Cache::forget("inquiry_{$this->inquiry->id}_user_{$this->userRole}_typing");

        $this->newMessage = '';
        $this->lastMessageId = $message->id;
        $this->inquiry->refresh();

        $this->dispatch('message-sent');
    }

    public function updateStatus($status)
    {
        if ($this->userRole !== 'host') {
            return;
        }

        $oldStatus = $this->inquiry->status;

        if ($oldStatus === 'accepted' && $status === 'rejected') {
            session()->flash('error', 'Cannot reject after accepting. Please close instead.');
            return;
        }

        $this->inquiry->update(['status' => $status]);
        $this->currentStatus = $status;

        $systemMessages = [
            'accepted' => "Great news! {$this->inquiry->host->firstName} has accepted your inquiry. They're interested in renting to you!",
            'rejected' => "Thank you for your interest. Unfortunately, this property is no longer available.",
            'closed' => "This inquiry has been closed.",
        ];

        if (isset($systemMessages[$status]) && $oldStatus !== $status) {
            $message = InquiryMessage::create([
                'inquiry_id' => $this->inquiry->id,
                'sender_id' => $this->inquiry->host_id,
                'sender_type' => 'host',
                'message' => $systemMessages[$status],
            ]);

            $this->lastMessageId = $message->id;

            // Send notification when accepted
            if ($status === 'accepted') {
                $this->inquiry->tenant->notify(new InquiryAccepted($this->inquiry));
                $this->dispatch('notification-sent');
            }
        }

        $this->inquiry->refresh();

        session()->flash('success', 'Status updated successfully!');
        $this->dispatch('message-sent');
        $this->dispatch('status-changed', status: $status);
    }

    // ========== VISIT SCHEDULING METHODS ==========

    public function toggleVisitForm()
    {
        $this->showVisitForm = !$this->showVisitForm;

        if ($this->showVisitForm) {
            $this->dispatch('visit-form-opened');
        }
    }

    public function scheduleVisit()
    {
        if ($this->userRole !== 'tenant') {
            return;
        }

        $this->validate([
            'proposedDate' => 'required|date|after:now',
            'visitNotes' => 'nullable|string|max:500',
        ]);

        if ($this->inquiry->visit) {
            session()->flash('error', 'A visit has already been scheduled for this inquiry.');
            return;
        }

        $visit = PropertyVisit::create([
            'inquiry_id' => $this->inquiry->id,
            'property_id' => $this->inquiry->property_id,
            'tenant_id' => Auth::id(),
            'host_id' => $this->inquiry->host_id,
            'proposed_date' => $this->proposedDate,
            'tenant_notes' => $this->visitNotes,
            'status' => 'pending',
        ]);

        $message = InquiryMessage::create([
            'inquiry_id' => $this->inquiry->id,
            'sender_id' => Auth::id(),
            'sender_type' => 'tenant',
            'message' => "Property visit requested for " . \Carbon\Carbon::parse($this->proposedDate)->format('F j, Y \a\t g:i A') . ($this->visitNotes ? "\n\nNotes: " . $this->visitNotes : ''),
        ]);

        // 🔔 Notify host
        $this->inquiry->host->notify(new VisitRequested($visit));
        $this->dispatch('notification-sent');

        $this->showVisitForm = false;
        $this->proposedDate = '';
        $this->visitNotes = '';
        $this->lastMessageId = $message->id;

        $this->inquiry->refresh();
        session()->flash('success', 'Visit request sent to host!');
        $this->dispatch('message-sent');
    }


    public function confirmVisit($visitId)
    {
        if ($this->userRole !== 'host') {
            return;
        }

        $visit = PropertyVisit::findOrFail($visitId);

        $visit->update([
            'status' => 'confirmed',
            'confirmed_date' => $visit->proposed_date,
        ]);

        $message = InquiryMessage::create([
            'inquiry_id' => $this->inquiry->id,
            'sender_id' => Auth::id(),
            'sender_type' => 'host',
            'message' => "Property visit confirmed for " . $visit->confirmed_date->format('F j, Y \a\t g:i A'),
        ]);

        // 🔔 Notify tenant
        $visit->tenant->notify(new VisitConfirmed($visit));
        $this->dispatch('notification-sent');

        $this->lastMessageId = $message->id;
        $this->inquiry->refresh();
        session()->flash('success', 'Visit confirmed!');
        $this->dispatch('message-sent');
    }

    public function completeVisit($visitId)
    {
        if ($this->userRole !== 'host') {
            return;
        }

        $visit = PropertyVisit::findOrFail($visitId);

        $visit->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        $message = InquiryMessage::create([
            'inquiry_id' => $this->inquiry->id,
            'sender_id' => Auth::id(),
            'sender_type' => 'host',
            'message' => "Property visit completed. Thank you for visiting!",
        ]);

        $this->lastMessageId = $message->id;
        $this->inquiry->refresh();
        session()->flash('success', 'Visit marked as completed!');
        $this->dispatch('message-sent');
    }
    // Show lease form
    public function toggleLeaseForm()
    {
        $this->showLeaseForm = !$this->showLeaseForm;

        // Pre-fill with property data
        if ($this->showLeaseForm) {
            $this->securityDeposit = $this->inquiry->property->propertyCost; // Default: 1 month rent
        }
    }

    // Host sends lease agreement
    public function sendLeaseAgreement()
    {
        if ($this->userRole !== 'host') {
            return;
        }

        $this->validate([
            'leaseStartDate' => 'required|date|after:today',
            'leaseEndDate' => 'required|date|after:leaseStartDate',
            'securityDeposit' => 'required|numeric|min:0',
            'specialConditions' => 'nullable|string|max:2000',
        ]);

        $propertyTerms = $this->inquiry->property->terms ?? 'Standard lease terms apply.';

        $lease = LeaseAgreement::create([
            'inquiry_id' => $this->inquiry->id,
            'property_id' => $this->inquiry->property_id,
            'tenant_id' => $this->inquiry->tenant_id,
            'host_id' => Auth::id(),
            'start_date' => $this->leaseStartDate,
            'end_date' => $this->leaseEndDate,
            'monthly_rent' => $this->inquiry->property->propertyCost,
            'security_deposit' => $this->securityDeposit,
            'terms_and_conditions' => $propertyTerms,
            'special_conditions' => $this->specialConditions,
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        $message = InquiryMessage::create([
            'inquiry_id' => $this->inquiry->id,
            'sender_id' => Auth::id(),
            'sender_type' => 'host',
            'message' => "Lease agreement sent!\n\nStart Date: " . \Carbon\Carbon::parse($this->leaseStartDate)->format('M j, Y') . "\nEnd Date: " . \Carbon\Carbon::parse($this->leaseEndDate)->format('M j, Y') . "\nMonthly Rent: ₱" . number_format($this->inquiry->property->propertyCost, 2) . "\nSecurity Deposit: ₱" . number_format($this->securityDeposit, 2),
        ]);

        // Notify tenant
        $this->inquiry->tenant->notify(new LeaseAgreementSent($lease));
        $this->dispatch('notification-sent');

        $this->showLeaseForm = false;
        $this->leaseStartDate = '';
        $this->leaseEndDate = '';
        $this->securityDeposit = '';
        $this->specialConditions = '';
        $this->lastMessageId = $message->id;

        $this->inquiry->refresh();
        session()->flash('success', 'Lease agreement sent to tenant!');
        $this->dispatch('message-sent');
    }


    // Tenant signs lease
    public function signLease($leaseId)
    {
        if ($this->userRole !== 'tenant') {
            return;
        }

        $lease = LeaseAgreement::findOrFail($leaseId);

        $lease->update([
            'status' => 'signed',
            'signed_at' => now(),
            'tenant_signature' => 'DIGITALLY_SIGNED',
            'signed_from_ip' => request()->ip(),
        ]);

        $message = InquiryMessage::create([
            'inquiry_id' => $this->inquiry->id,
            'sender_id' => Auth::id(),
            'sender_type' => 'tenant',
            'message' => "Lease agreement signed! Waiting for move-in date.",
        ]);

        // 🔔 Notify host
        $lease->host->notify(new LeaseAgreementSigned($lease));
        $this->dispatch('notification-sent');

        $this->lastMessageId = $message->id;
        $this->inquiry->refresh();
        session()->flash('success', 'Lease agreement signed!');
        $this->dispatch('message-sent');
    }


    public function render()
    {
        $messages = $this->inquiry->messages()->with('sender')->get();
        $visit = $this->inquiry->visit; // Load visit relationship
        $lease = $this->inquiry->leaseAgreement;

        return view('livewire.inquiry-chat', [
            'messages' => $messages,
            'visit' => $visit,
            'lease' => $lease,
        ]);
    }
}
