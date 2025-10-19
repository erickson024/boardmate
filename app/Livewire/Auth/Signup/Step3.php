<?php

namespace App\Livewire\Auth\Signup;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Step3 extends Component
{
    use WithFileUploads;

    public $profile_photo;

    public function submit()
    {
        $this->validate([
            'profile_photo' => 'required|image|max:2048', // 2MB max
        ]);

        // Store the image in 'public/profile-photos' directory
        $path = $this->profile_photo->store('profile-photos', 'public');

        // You can store this $path in the session or pass it to the next step
        session(['signup.profile_photo' => $path]);

        // Move to next step
        $this->dispatch('goToStep', 4);
    }

    public function back()
    {
        $this->dispatch('goToStep', 2);
    }

    public function render()
    {
        return view('livewire.auth.signup.step3');
    }
}
