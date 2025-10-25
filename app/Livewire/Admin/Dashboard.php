<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class Dashboard extends Component
{
     public $users;

    public function mount()
    {
        // Load all users
        $this->users = User::all();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
