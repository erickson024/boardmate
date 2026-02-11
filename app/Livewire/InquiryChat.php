<?php

namespace App\Livewire;

use App\Models\Inquiry;
use App\Models\InquiryMessage;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class InquiryChat extends Component
{
    public Inquiry $inquiry;
    public $newMessage = '';
    public $userRole;
    public $lastMessageId = 0;
    public $otherUserTyping = false;
    public $currentStatus; // Track current status

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
        $this->currentStatus = $inquiry->status; // Store initial status

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
        // Check typing status
        $otherUserRole = $this->userRole === 'tenant' ? 'host' : 'tenant';
        $this->otherUserTyping = Cache::get(
            "inquiry_{$this->inquiry->id}_user_{$otherUserRole}_typing",
            false
        );

        // Refresh inquiry to get latest status
        $this->inquiry->refresh();

        // Check if status changed
        if ($this->currentStatus !== $this->inquiry->status) {
            $this->currentStatus = $this->inquiry->status;
            $this->dispatch('status-changed', status: $this->inquiry->status);
        }

        // Check for new messages
        $latestMessage = $this->inquiry->messages()->latest()->first();
        
        if ($latestMessage && $latestMessage->id > $this->lastMessageId) {
            $this->lastMessageId = $latestMessage->id;
            $this->markMessagesAsRead();
            $this->dispatch('message-received');
        }
    }

    public function sendMessage()
    {
        // Don't allow sending if inquiry is closed or rejected
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
        
        // Prevent rejection after acceptance (optional)
        if ($oldStatus === 'accepted' && $status === 'rejected') {
            session()->flash('error', 'Cannot reject after accepting. Please close instead.');
            return;
        }

        $this->inquiry->update(['status' => $status]);
        $this->currentStatus = $status;
        
        // Create system message to notify tenant
        $systemMessages = [
            'accepted' => "🎉 Great news! {$this->inquiry->host->firstName} has accepted your inquiry. They're interested in renting to you!",
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
        }
        
        $this->inquiry->refresh();
        
        session()->flash('success', 'Status updated successfully!');
        $this->dispatch('message-sent');
        $this->dispatch('status-changed', status: $status);
    }

    public function render()
    {
        $messages = $this->inquiry->messages()->with('sender')->get();

        return view('livewire.inquiry-chat', [
            'messages' => $messages,
        ]);
    }
}