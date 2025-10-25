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
    public $photo;
    public $photoPreview;
    public $hasPhoto;

    protected $rules = [
        'firstname' => 'required|string|max:255',
        'lastname'  => 'required|string|max:255',
        'address'   => 'required|string|max:255',
        'photo'     => 'nullable|image|max:10048',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->firstname = $user->firstname;
        $this->lastname  = $user->lastname;
        $this->address   = $user->address;
        $this->photoPreview = $user->profile_photo ? Storage::url($user->profile_photo) : null;
        $this->hasPhoto = !is_null($user->profile_photo);
    }

    public function getUserAvatarProperty()
    {
        $user = Auth::user();
        $photo = $user->profile_photo;

        if ($photo && !str_starts_with($photo, 'http')) {
            return asset('storage/' . $photo);
        }

        return $photo ?: null;
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048',
        ]);

        if (auth()->user()->profile_photo) {
            Storage::delete(auth()->user()->profile_photo);
        }

        $path = $this->photo->store('profile-photos', 'public');
        auth()->user()->update(['profile_photo' => $path]);

        $this->photoPreview = Storage::url($path);
        $this->hasPhoto = true;

        session()->flash('success', 'Profile photo updated successfully!');
    }

    public function removePhoto()
    {
        $user = auth()->user();

        if ($user->profile_photo) {
            Storage::delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
        }

        $this->photoPreview = null;
        $this->hasPhoto = false;
        session()->flash('success', 'Profile photo removed successfully!');
    }

    public function updateProfile()
    {
        $this->validate();

        $user = Auth::user();
        $user->update([
            'firstname' => $this->firstname,
            'lastname'  => $this->lastname,
            'address'   => $this->address,
        ]);

        session()->flash('success', 'Profile updated successfully!');
        $this->dispatch('profileUpdated');
    }

    public function render()
    {
        return view('livewire.profile-update.profile-form');
    }
}
