<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class Dashboard extends Component
{
    public string $active = 'environment';

    public function setTab(string $tab)
    {
        $this->active = $tab;
    }

    // Computed property for user count
    public function getUserCountProperty()
    {
        // Count all users
        return User::count();
    }

     // Optional: count only online users
    public function getOnlineUsersProperty()
    {
        return User::all()->filter(function ($user) {
            return Cache::has('user-is-online-' . $user->id);
        })->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
