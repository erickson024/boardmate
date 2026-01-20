<?php

namespace App\Livewire\Users\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Password extends Component
{
    public $currentPassword = '';
    public $newPassword = '';
    public $confirmNewPassword = '';
    
    public $strengthScore = 0;

    // Livewire hook for password updates
    public function updatedNewPassword($value)
    {
        $this->checkStrength($value);
    }

    // Simple password strength checker
    private function checkStrength($password)
    {
        $score = 0;

        if (strlen($password) >= 8) $score++;
        if (preg_match('/[A-Z]/', $password)) $score++;
        if (preg_match('/[a-z]/', $password)) $score++;
        if (preg_match('/[0-9]/', $password)) $score++;
        if (preg_match('/[@$!%*#?&]/', $password)) $score++;

        $this->strengthScore = $score;
    }

    public function updatePassword()
    {
        // Validate all fields on submit
        $this->validate([
            'currentPassword' => 'required|string|min:8',
            'newPassword' => 'required|string|min:8|different:currentPassword',
            'confirmNewPassword' => 'required|string|same:newPassword',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($this->currentPassword, $user->password)) {
            $this->addError('currentPassword', 'The current password is incorrect.');
            return;
        }

        // Update the password
        $user->update([
            'password' => Hash::make($this->newPassword)
        ]);

        // Clear the form
        $this->reset(['currentPassword', 'newPassword', 'confirmNewPassword', 'strengthScore']);

        session()->flash('password-message', 'Password updated successfully!');
        
        $this->dispatch('password-updated');
    }

    public function render()
    {
        return view('livewire.users.settings.password');
    }
}