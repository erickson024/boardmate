<?php

namespace App\Livewire\VerifiedHostList;

use App\Models\User;
use Livewire\Component;

class VerifiedHostInfo extends Component
{
    public $host;
    public $hostId;

    public function mount($id)
    {
        $this->hostId = $id;
        $this->host = User::where('role', 'host')
            ->with(['properties']) // Remove .images since it's not a relationship
            ->withCount('properties')
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.verified-host-list.verified-host-info');
    }
}