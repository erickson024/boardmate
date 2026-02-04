<?php

namespace App\Livewire\Tenant;

use Livewire\Component;
use App\Models\Inquiry;
use Livewire\WithPagination;

class MyInquiries extends Component
{
    use WithPagination;

    public $statusFilter = 'all';
    
    protected $paginationTheme = 'bootstrap';

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function cancelInquiry($inquiryId)
    {
        $inquiry = Inquiry::where('id', $inquiryId)
            ->where('user_id', auth()->id())
            ->first();

        if ($inquiry && $inquiry->status === 'pending') {
            $inquiry->update(['status' => 'cancelled']);
            session()->flash('success', 'Inquiry cancelled successfully');
        }
    }

    public function deleteInquiry($inquiryId)
    {
        $inquiry = Inquiry::where('id', $inquiryId)
            ->where('user_id', auth()->id())
            ->whereIn('status', ['declined', 'cancelled'])
            ->first();

        if ($inquiry) {
            $inquiry->delete();
            session()->flash('success', 'Inquiry deleted successfully');
        }
    }

    public function render()
    {
        $query = Inquiry::with(['property.user', 'host'])
            ->where('user_id', auth()->id())
            ->latest();

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $inquiries = $query->paginate(10);

        // Get counts for badges
        $counts = Inquiry::where('user_id', auth()->id())
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('livewire.tenant.my-inquiries', [
            'inquiries' => $inquiries,
            'counts' => $counts,
        ]);
    }
}