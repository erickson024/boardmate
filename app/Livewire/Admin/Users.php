<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Livewire\Attributes\On;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = null;

    protected $queryString = ['roleFilter'];

    // Define role filters configuration
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
            'icon' => 'bi-house-door-fill',
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
        // Initialize any needed data
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

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function filterByRole($role)
    {
        $this->roleFilter = $this->roleFilter === $role ? null : $role;
        $this->resetPage();
    }

    /* ===== Role Counts ===== */

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
        $users = User::query()
            ->when(
                $this->roleFilter,
                fn($q) =>
                $q->where('role', $this->roleFilter)
            )
            ->when(
                $this->search,
                fn($q) =>
                $q->where(function ($query) {
                    $query->where('firstName', 'like', "%{$this->search}%")
                        ->orWhere('lastName', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                })
            )
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.users', compact('users'));
    }
}