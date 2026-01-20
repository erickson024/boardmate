<?php

namespace App\Livewire\Users\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Email extends Component
{
    public $currentEmail = '';
    public $newEmail = '';

    public function mount()
    {
        $user = Auth::user();
        $this->currentEmail = $user->email ?? '';
    }

    public function updateEmail()
    {
        $userId = Auth::id();

        // Validate the new email
        $this->validate([
            'newEmail' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
                'different:currentEmail'
            ],
        ], [
            'newEmail.different' => 'The new email must be different from your current email.',
            'newEmail.unique' => 'This email address is already in use.',
        ]);

        $user = Auth::user();

        // Update the email and reset verification
        $user->email = $this->newEmail;
        $user->email_verified_at = null;
        $user->save();

        session()->flash('email-message', 'Email address updated successfully! Please verify your new email address.');
        
        // Optional: Send email verification notification
        // $user->sendEmailVerificationNotification();
        
        $this->dispatch('email-updated');
        
        // Redirect to reload the page
        return redirect()->to(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.users.settings.email');
    }
}