<?php

namespace App\Livewire\Tenant;

use Livewire\Component;
use App\Models\HostingRequest;
use App\Models\User;
use App\Notifications\NewHostRequest;

class HostRequest extends Component
{
    public $request;
    public $lastNotifiedStatus = null;

    public function mount()
    {
        $this->request = HostingRequest::where('user_id', auth()->id())->latest()->first();
        $this->lastNotifiedStatus = $this->request?->status;
    }

    public function submitRequest()
    {
        $user = auth()->user();

        // Check if already a host
        if ($user->role === 'host') {
            $this->dispatch('toast', title: 'Already a Host', message: 'You are already a host.', type: 'info');
            return redirect()->route('host.dashboard');
        }

        // Check for pending request
        if ($this->request && $this->request->status === 'pending') {
            $this->dispatch('toast', title: 'Pending Request', message: 'You already have a pending request.', type: 'warning');
            return;
        }

        // Create new request
        $this->request = HostingRequest::create([
            'user_id' => $user->id,
            'status'  => 'pending',
        ]);

        $this->lastNotifiedStatus = 'pending';

        // Notify all admins
        User::where('role', 'admin')->each(fn ($admin) => $admin->notify(new NewHostRequest($this->request)));

        $this->dispatch('toast', title: 'Request Sent', message: 'Your request is under review.', type: 'success');
    }

    public function checkRequestStatus()
    {
        $latest = HostingRequest::where('user_id', auth()->id())->latest()->first();

        if (!$latest || $this->lastNotifiedStatus === $latest->status) {
            return;
        }

        $this->request = $latest;
        $this->lastNotifiedStatus = $latest->status;

        if ($latest->status === 'approved') {
            auth()->user()->refresh(); // Refresh user role
            $this->dispatch('toast', title: 'Approved!', message: 'You are now a host!', type: 'success');
            return $this->redirect(route('host.welcome'));
        }

        if ($latest->status === 'denied') {
            $message = $latest->reason ?? 'Request denied. Contact support.';
            $this->dispatch('toast', title: 'Request Denied', message: $message, type: 'danger');
        }
    }

    public function render()
    {
        return view('livewire.tenant.host-request');
    }
}

