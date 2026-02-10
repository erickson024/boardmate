<?php

namespace App\Livewire;

use App\Models\Inquiry;
use App\Models\InquiryMessage;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class InquiryChat extends Component
{
    public Inquiry $inquiry;
    public $newMessage = '';
    public $userRole;

    protected $rules = [
        'newMessage' => 'required|string|min:1|max:1000',
    ];

    public function mount(Inquiry $inquiry)
    {
        // Check authorization
        $user = Auth::user();
        
        if ($user->id !== $inquiry->tenant_id && $user->id !== $inquiry->host_id) {
            abort(403, 'Unauthorized access to this inquiry.');
        }

        $this->inquiry = $inquiry;
        $this->userRole = $user->id === $inquiry->tenant_id ? 'tenant' : 'host';

        // Mark as read when opened
        if ($this->userRole === 'host' && !$inquiry->read_by_host) {
            $inquiry->markAsRead();
        }

        // Mark all messages from the other party as read
        $this->markMessagesAsRead();
    }

    public function markMessagesAsRead()
    {
        $this->inquiry->messages()
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function sendMessage()
    {
        $this->validate();

        InquiryMessage::create([
            'inquiry_id' => $this->inquiry->id,
            'sender_id' => Auth::id(),
            'sender_type' => $this->userRole,
            'message' => $this->newMessage,
        ]);

        // Update inquiry status if host is replying
        if ($this->userRole === 'host' && $this->inquiry->status === 'pending') {
            $this->inquiry->update(['status' => 'replied']);
        }

        $this->newMessage = '';
        $this->inquiry->refresh();
        
        // Scroll to bottom (we'll add this in the view)
        $this->dispatch('message-sent');
    }

    public function updateStatus($status)
    {
        // Only host can update status
        if ($this->userRole !== 'host') {
            return;
        }

        $this->inquiry->update(['status' => $status]);
        $this->inquiry->refresh();
        
        session()->flash('success', 'Status updated successfully!');
    }

    public function render()
    {
        // Reload messages
        $messages = $this->inquiry->messages()->with('sender')->get();

        return view('livewire.inquiry-chat', [
            'messages' => $messages,
        ]);
    }
}