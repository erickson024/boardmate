<?php

namespace App\Livewire\ProfileUpdate;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileForm extends Component
{
    use WithFileUploads;

    public $firstname;
    public $lastname;
    public $address;
    public $avatar;

    protected $rules = [
        'firstname' => 'required|string|max:255',
        'lastname'  => 'required|string|max:255',
        'address'   => 'required|string|max:255',
        'avatar'    => 'nullable|image|max:10048',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->firstname = $user->firstname;
        $this->lastname  = $user->lastname;
        $this->address   = $user->address;
    }

    // validate avatar on change (optional)
    public function updatedAvatar()
    {
        $this->validateOnly('avatar');
    }

    public function updateProfile()
    {
        $this->validate();

        $user = Auth::user();

        if ($this->avatar) {
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            $user->avatar = $this->avatar->store('avatars', 'public');
        }

        $user->firstname = $this->firstname;
        $user->lastname  = $this->lastname;
        $user->address   = $this->address;
        $user->save();

        session()->flash('success', 'Profile updated successfully!');
        $this->dispatch('profileUpdated'); // optional: for JS listeners if desired
    }

    public function render()
    {
        return view('livewire.profile-update.profile-form');
    }
}
