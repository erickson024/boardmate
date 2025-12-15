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
        $this->request = HostingRequest::where('user_id', auth()->id())
            ->latest()
            ->first();

        $this->lastNotifiedStatus = $this->request?->status;
    }

    public function submitRequest()
    {
        $user = auth()->user();

        // Prevent duplicate pending request
        if ($this->request && $this->request->status === 'pending') {
            $this->dispatch(
                'toast',
                title: 'Host Request',
                message: 'You already have a pending host request.',
                type: 'warning'
            );
            return;
        }

        $this->request = HostingRequest::create([
            'user_id' => $user->id,
            'status'  => 'pending',
        ]);

        $this->lastNotifiedStatus = 'pending';

        // Notify admins
        User::where('role', 'admin')->each(
            fn ($admin) => $admin->notify(new NewHostRequest($this->request))
        );

        $this->dispatch(
            'toast',
            title: 'Host Request Sent',
            message: 'Your request has been submitted and is under review.',
            type: 'success'
        );
    }

    /**
     * Poll every 5s — only react when status CHANGES
     */
    public function checkRequestStatus()
    {
        $latest = HostingRequest::where('user_id', auth()->id())
            ->latest()
            ->first();

        if (!$latest) {
            return;
        }

        // Detect real change
        if ($this->lastNotifiedStatus !== $latest->status) {

            $this->request = $latest;
            $this->lastNotifiedStatus = $latest->status;

            if ($latest->status === 'approved') {
                $this->dispatch(
                    'toast',
                    title: 'Host Request Approved',
                    message: 'Your request has been approved!',
                    type: 'success'
                );
            }

            if ($latest->status === 'denied') {
                $this->dispatch(
                    'toast',
                    title: 'Host Request Denied',
                    message: 'Your request was denied. Please contact support.',
                    type: 'danger'
                );
            }
        }
    }

    public function render()
    {
        return view('livewire.tenant.host-request');
    }
}
