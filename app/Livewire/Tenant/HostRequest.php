<?php

namespace App\Livewire\Tenant;

use Livewire\Component;
use App\Models\HostingRequest;
use App\Models\User;
use App\Notifications\NewHostRequest;

class HostRequest extends Component
{
    public function submitRequest()
    {
        $user = auth()->user();

        // Prevent duplicate pending requests
        if (
            HostingRequest::where('user_id', $user->id)
                ->where('status', 'pending')
                ->exists()
        ) {
            $this->dispatch(
                'toast',
                title: 'Host Request',
                message: 'You already have a pending host request.',
                type: 'warning'
            );
            return;
        }

        $request = HostingRequest::create([
            'user_id' => $user->id,
            'status'  => 'pending',
        ]);

        // Notify admins
        User::where('role', 'admin')->each(
            fn ($admin) => $admin->notify(new NewHostRequest($request))
        );

        // ✅ Success toast
        $this->dispatch(
            'toast',
            title: 'Host Request Sent',
            message: 'Your request has been submitted and is under review.',
            time: now()->diffForHumans(),
            type: 'success'
        );
    }

    public function render()
    {
        return view('livewire.tenant.host-request', [
            'request' => HostingRequest::where('user_id', auth()->id())->latest()->first()
        ]);
    }
}
