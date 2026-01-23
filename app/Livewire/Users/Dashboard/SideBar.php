<?php

namespace App\Livewire\Users\Dashboard;

use Livewire\Component;

class SideBar extends Component
{
    public $activeMenu = 'dashboard';

    public function setActive($menu)
    {
        $this->activeMenu = $menu;
        $this->dispatch('menu-changed', menu: $menu);
    }
    
    public function render()
    {
        return view('livewire.users.dashboard.side-bar');
    }
}
