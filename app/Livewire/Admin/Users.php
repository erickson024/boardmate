<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = null;

    protected $queryString = ['roleFilter'];

    // Role filters configuration
    protected $roles = [
        [
            'value' => null,
            'label' => 'All Users',
            'icon' => 'bi-people-fill',
            'bgActive' => 'bg-primary text-light border-primary',
            'bgInactive' => 'bg-primary bg-opacity-10 text-primary',
            'countProperty' => 'totalCount',
        ],
        [
            'value' => 'admin',
            'label' => 'Admins',
            'icon' => 'bi-shield-lock-fill',
            'bgActive' => 'bg-warning text-dark border-warning',
            'bgInactive' => 'bg-warning bg-opacity-15 text-warning-emphasis',
            'countProperty' => 'adminCount',
        ],
        [
            'value' => 'host',
            'label' => 'Hosts',
            'icon' => 'bi-person-fill-check',
            'bgActive' => 'bg-success text-light border-success',
            'bgInactive' => 'bg-success bg-opacity-15 text-success-emphasis',
            'countProperty' => 'hostCount',
        ],
        [
            'value' => 'tenant',
            'label' => 'Tenants',
            'icon' => 'bi-people-fill',
            'bgActive' => 'bg-secondary text-light border-secondary',
            'bgInactive' => 'bg-secondary bg-opacity-20 text-secondary-emphasis',
            'countProperty' => 'tenantCount',
        ],
    ];

    public function mount()
    {
        if (Auth::check()) {
            Auth::user()->updateActivity();
        }
    }

    #[On('user-created')]
    #[On('user-updated')]
    #[On('user-deleted')]
    public function refreshUsers()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function filterByRole($role)
    {
        $this->roleFilter = $this->roleFilter === $role ? null : $role;
        $this->resetPage();
    }

    public function getTotalCountProperty()
    {
        return User::count();
    }

    public function getAdminCountProperty()
    {
        return User::where('role', 'admin')->count();
    }

    public function getHostCountProperty()
    {
        return User::where('role', 'host')->count();
    }

    public function getTenantCountProperty()
    {
        return User::where('role', 'tenant')->count();
    }

    public function render()
    {
        // Update current user activity
        if (Auth::check()) {
            Auth::user()->updateActivity();
        }

        $users = User::query()
            ->when($this->roleFilter, fn($q) => $q->where('role', $this->roleFilter))
            ->when($this->search, fn($q) => $q->where(function ($query) {
                $query->where('firstName', 'like', "%{$this->search}%")
                    ->orWhere('lastName', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            }))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Attach last_activity from cache with proper Carbon conversion
        $users->getCollection()->transform(function ($user) {
            $lastActivityValue = Cache::get('user-last-activity-' . $user->id);
            
            // Convert to Carbon if it exists and is not already a Carbon instance
            if ($lastActivityValue) {
                $user->last_activity = $lastActivityValue instanceof Carbon 
                    ? $lastActivityValue 
                    : Carbon::parse($lastActivityValue);
            } else {
                $user->last_activity = null;
            }
            
            Log::info('User: ' . $user->email . ' | Last Activity: ' . ($user->last_activity ? $user->last_activity->toDateTimeString() : 'null') . ' | Online: ' . ($user->isOnline() ? 'Yes' : 'No'));
            
            return $user;
        });

        return view('livewire.admin.users', compact('users'));
    }
}