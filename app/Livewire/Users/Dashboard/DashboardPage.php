<?php

namespace App\Livewire\Users\Dashboard;

use Livewire\Component;

class DashboardPage extends Component
{
    public $currentTab = 'user-stat';

      protected $queryString = [
        'currentTab' => ['except' => 'user-stat'],
    ];

    public function setTab($tab)
    {
        $this->currentTab = $tab;
        $this->dispatch('tab-changed', tab: $tab);
    }

    public function render()
    {
        return view('livewire.users.dashboard.dashboard-page');
    }
}