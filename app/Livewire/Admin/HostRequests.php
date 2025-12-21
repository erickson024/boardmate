<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\HostingRequest;
use App\Models\User;

class HostRequests extends Component
{
     public function approve($id)
    {
        $request = HostingRequest::findOrFail($id);
        $request->status = 'accepted';
        $request->save();

        // Update user role
        $user = $request->user;
        $user->role = 'verified_host';
        $user->save();

        $this->dispatch('hostRequestUpdated')->to('admin.dashboard');
    }

     public function deny($id, $reason = null)  
    {
        $request = HostingRequest::findOrFail($id);
        $request->status = 'denied';
        $request->reason = $reason;
        $request->save();

        $this->dispatch('hostRequestUpdated')->to('admin.dashboard');
    }


    public function render()
    {
        $requests = HostingRequest::where('status', 'pending')->with('user')->get();
        return view('livewire.admin.host-requests', ['requests' => $requests]);
    }
}
