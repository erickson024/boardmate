<?php

namespace App\Livewire\Host;

use App\Models\Inquiry;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class InquiryList extends Component
{
    public $filter = 'all'; // all, pending, replied, closed

    public function render()
    {
        $query = Inquiry::where('host_id', Auth::id())
            ->with(['property', 'tenant'])
            ->latest();

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        $inquiries = $query->get();
        
        $unreadCount = Inquiry::where('host_id', Auth::id())
            ->where('read_by_host', false)
            ->count();

        return view('livewire.host.inquiry-list', [
            'inquiries' => $inquiries,
            'unreadCount' => $unreadCount,
        ]);
    }
}