<?php

namespace App\Livewire\Users\Settings;

use Livewire\Component;

class SettingPage extends Component
{
    public $currentTab = 'basic-info';

    public function setTab($tab)
    {
        $this->currentTab = $tab;
    }
    
    public function render()
    {
        return view('livewire.users.settings.setting-page');
    }
}
