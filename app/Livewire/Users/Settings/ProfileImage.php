<?php

namespace App\Livewire\Users\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileImage extends Component
{
    use WithFileUploads;

    public $profileImage;
    public $currentProfileImage;

    public function mount()
    {
        $user = Auth::user();
        $this->currentProfileImage = $user->profile_image ?? null;
    }

    public function updatedProfileImage()
    {
        $this->validate([
            'profileImage' => 'image|max:2048', // 2MB Max
        ]);
    }

    public function updateProfileImage()
    {
        $this->validate([
            'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:4048',
        ]);

        $user = Auth::user();

        // Delete old profile image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Store new profile image
        $path = $this->profileImage->store('profile-images', 'public');

        // Update user profile image
        $user->update([
            'profile_image' => $path,
        ]);

        // Update current profile image display
        $this->currentProfileImage = $path;
        $this->reset('profileImage');

        session()->flash('profile-image-message', 'Profile image updated successfully!');
        
        $this->dispatch('profile-image-updated');
    }

    public function removeProfileImage()
    {
        $user = Auth::user();

        // Delete profile image file
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Update user profile image to null
        $user->update([
            'profile_image' => null,
        ]);

        $this->currentProfileImage = null;
        $this->reset('profileImage');

        session()->flash('profile-image-message', 'Profile image removed successfully!');
        
        $this->dispatch('profile-image-removed');
    }

    public function render()
    {
        return view('livewire.users.settings.profile-image');
    }
}