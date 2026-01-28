<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\HostingRequest;
use Illuminate\Support\Facades\DB;
use App\Notifications\HostRequestApproved;
use App\Notifications\HostRequestDenied;

class HostRequests extends Component
{
    public $showDenyModal = false;
    public $denyReason = '';
    public $selectedRequestId = null;

    public function approve($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $request = HostingRequest::findOrFail($id);
                
                if ($request->status !== 'pending') {
                    $this->dispatch('toast', title: 'Invalid Action', message: 'Request already processed.', type: 'warning');
                    return;
                }

                // Update request
                $request->update([
                    'status' => 'approved',
                    'reviewed_at' => now(),
                    'reviewed_by' => auth()->id(),
                ]);

                // Update user role
                $request->user->update(['role' => 'host']);

                // Send notification
                $request->user->notify(new HostRequestApproved($request));

                $this->dispatch('toast', title: 'Approved', message: 'User is now a host.', type: 'success');
            });
            
        } catch (\Exception $e) {
            $this->dispatch('toast', title: 'Error', message: $e->getMessage(), type: 'danger');
        }
    }

    public function openDenyModal($id)
    {
        $this->selectedRequestId = $id;
        $this->denyReason = '';
        $this->showDenyModal = true;
    }

    public function closeDenyModal()
    {
        $this->showDenyModal = false;
        $this->selectedRequestId = null;
        $this->denyReason = '';
    }

    public function confirmDeny()
    {
        $this->validate([
            'denyReason' => 'required|string|min:10|max:500',
        ]);

        try {
            DB::transaction(function () {
                $request = HostingRequest::findOrFail($this->selectedRequestId);
                
                if ($request->status !== 'pending') {
                    $this->dispatch('toast', title: 'Invalid Action', message: 'Request already processed.', type: 'warning');
                    return;
                }

                $request->update([
                    'status' => 'denied',
                    'reason' => $this->denyReason,
                    'reviewed_at' => now(),
                    'reviewed_by' => auth()->id(),
                ]);

                $request->user->notify(new HostRequestDenied($request));

                $this->dispatch('toast', title: 'Denied', message: 'Request has been denied.', type: 'info');
            });

            $this->closeDenyModal();
            
        } catch (\Exception $e) {
            $this->dispatch('toast', title: 'Error', message: $e->getMessage(), type: 'danger');
        }
    }

    public function render()
    {
        $requests = HostingRequest::where('status', 'pending')
            ->with('user')
            ->latest()
            ->get();
            
        return view('livewire.admin.host-requests', ['requests' => $requests]);
    }
}