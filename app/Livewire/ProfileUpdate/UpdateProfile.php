<?php

namespace App\Livewire\ProfileUpdate;

use Livewire\Component;

class UpdateProfile extends Component
{
    public $active = 'profiles';

    public function setTab($tab)
    {
        $this->active = $tab;
    }

    public function render()
    {
        return view('livewire.profile-update.update-profile');
    }
}
