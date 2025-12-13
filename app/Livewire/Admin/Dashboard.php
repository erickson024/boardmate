<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Dashboard extends Component
{
    public string $active = 'environment';

    public function setTab(string $tab)
    {
        $this->active = $tab;
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
