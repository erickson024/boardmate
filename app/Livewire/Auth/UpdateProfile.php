<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UpdateProfile extends Component
{
    use WithFileUploads;

    public $firstname;
    public $lastname;
    public $email;
    public $address;
    public $avatar;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'Your current password is incorrect.');
            return;
        }

        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        // Clear input fields
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('success', 'Password updated successfully!');
    }


    public function mount()
    {
        $user = Auth::user();
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->email = $user->email;
        $this->address = $user->address;
    }

    public function updateProfile()
    {
        $this->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'avatar'    => 'nullable|image|max:10048', 
        ]);

        $user = Auth::user();

        // Save avatar if uploaded
        if ($this->avatar) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }

            // Store new avatar in storage/app/public/avatars
            $path = $this->avatar->store('avatars', 'public');
            $user->avatar = $path;
        }




        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;

         if ($user->email !== $this->email) {
            $user->email = $this->email;
            $user->email_verified_at = null; // force re-verification if you want
        }

        $user->address = $this->address;

        $user->save();

        session()->flash('success', 'Profile updated successfully!');
    }


    public function render()
    {
        return view('livewire.auth.update-profile');
    }
}
