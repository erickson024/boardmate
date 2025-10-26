<?php

namespace App\Livewire\ProfileUpdate;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordForm extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $showSetPasswordForm = false;

    protected function rules()
    {
        if (Auth::user()->google_id) {
            // OAuth users only need to set new password
            return [
                'new_password' => 'required|min:8|confirmed',
            ];
        }

        // Regular users need current + new password
        return [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ];
    }

    public function showPasswordForm()
    {
        $this->showSetPasswordForm = true;
    }

    public function hidePasswordForm()
    {
        $this->showSetPasswordForm = false;
        $this->reset(['new_password', 'new_password_confirmation']);
    }

    public function updatePassword()
    {
        $this->validate();

        if (Auth::user()->google_id) {
            // OAuth users can set new password directly
            Auth::user()->update([
                'password' => Hash::make($this->new_password),
            ]);
        } else {
            // Regular users need password verification
            if (!Hash::check($this->current_password, Auth::user()->password)) {
                $this->addError('current_password', 'Your current password is incorrect.');
                return;
            }

            Auth::user()->update([
                'password' => Hash::make($this->new_password),
            ]);
        }

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->showSetPasswordForm = false;
        session()->flash('success', 'Password updated successfully!');
        $this->dispatch('passwordUpdated');
    }

    public function render()
    {
        return view('livewire.profile-update.password-form');
    }
}