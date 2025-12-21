<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\HostingRequest;
use Illuminate\Support\Facades\Cache;

class Dashboard extends Component
{
    public string $active = 'users';

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
    
    
    protected $listeners = ['hostRequestUpdated' => '$refresh'];
    public function getHostRequestsCountProperty()
    {
        return HostingRequest::where('status', 'pending')->count(); // Or however you fetch pending requests
    }

    // Optional: count only online users
    public function getOnlineUsersProperty()
    {
        return User::all()->filter(function ($user) {
            return Cache::has('user-is-online-' . $user->id);
        })->count();
    }


    public function getNavItemsProperty()
    {
        return [
            [
                'key'   => 'environment',
                'label' => 'System Status',
                'icon'  => 'bi-bar-chart-fill',
                'badge' => null,
            ],
            [
                'key'   => 'host',
                'label' => 'Host Requests',
                'icon'  => 'bi bi-send-check-fill',
                'badge' => $this->hostRequestsCount ?? 0,
            ],
            [
                'key'   => 'users',
                'label' => 'Users',
                'icon'  => 'bi-person-lines-fill',
                'badge' => null,
            ],
            [
                'key'   => 'properties',
                'label' => 'Properties',
                'icon'  => 'bi bi-houses-fill',
                'badge' => null,
            ],
            [
                'key'   => 'messages',
                'label' => 'Messages',
                'icon'  => 'bi bi-chat-dots-fill',
                'badge' => null,
            ],
        ];
      
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
