<?php

namespace App\Livewire\Users\Dashboard;

use Livewire\Component;
use Illuminate\Support\Str;

class UserStat extends Component
{
    public function getFullNameAttribute()
    {
        return Str::title($this->firstName . ' ' . $this->lastName);
    }

    public function render()
    {
        return view('livewire.users.dashboard.user-stat');
    }
}
