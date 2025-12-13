<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Users extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage(); // reset pagination on search
    }

    public function render()
    {
         $users = User::query()
            ->when($this->search, fn($query) =>
                $query->where('firstName', 'like', "%{$this->search}%")
                      ->orWhere('lastName', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
            )
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.users',[
            'users' => $users,
        ]);
    }
}
