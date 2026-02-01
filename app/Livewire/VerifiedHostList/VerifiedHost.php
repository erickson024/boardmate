<?php

namespace App\Livewire\VerifiedHostList;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class VerifiedHost extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'newest';
    public $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'newest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function getHostsProperty()
    {
        $query = User::where('role', 'host')
            ->withCount('properties');

        if ($this->search) {
            $query->where(function($q) {
                $q->whereRaw("CONCAT(firstName, ' ', lastName) LIKE ?", ['%' . $this->search . '%'])
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        switch ($this->sortBy) {
            case 'alphabetical':
                $query->orderBy('firstName', 'asc');
                break;
            case 'most_properties':
                $query->orderBy('properties_count', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.verified-host-list.verified-host', [
            'hosts' => $this->hosts,
            'totalHosts' => User::where('role', 'host')->count()
        ]);
    }
}