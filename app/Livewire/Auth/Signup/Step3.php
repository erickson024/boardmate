<?php

namespace App\Livewire\Auth\Signup;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Step3 extends Component
{
    use WithFileUploads;

    public $profile_photo;

    protected $rules = [
        'profile_photo' => 'nullable|image|max:2048', 
    ];

    public function mount()
    {
        $signupData = session()->get('signup', []);
        $this->fill($signupData);
    }

     private function saveProfilePhoto()
    {
        // Determine if new upload or existing file path
        if ($this->profile_photo instanceof TemporaryUploadedFile) {
            // Validate only when it's a new upload
            $this->validate();

            // Store the image in 'public/profile-photos' directory
            $path = $this->profile_photo->store('profile-photos', 'public');
        } else {
            // Use existing file path if user is going back
            $path = $this->profile_photo;
        }

        // Save the path (string) in session
        $signupData = session()->get('signup', []);
        $signupData = array_merge($signupData, [
            'profile_photo' => $path,
        ]);
        session()->put('signup', $signupData);

        return $path;
    }

    public function submit()
    {
        $path = $this->saveProfilePhoto();
       
        // Move to next step
        $this->dispatch('goToStep', 4);
    }

    public function back()
    {
        $path = $this->saveProfilePhoto();

        $this->dispatch('goToStep', 2);
    }

    public function render()
    {
        return view('livewire.auth.signup.step3');
    }
}
