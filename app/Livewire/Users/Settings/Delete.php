<?php

namespace App\Livewire\Users\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Delete extends Component
{
    public $password = '';
    public $showConfirmModal = false;

    public function confirmDelete()
    {
        // Validate password is entered
        $this->validate([
            'password' => 'required|string',
        ], [
            'password.required' => 'Please enter your password to continue.',
        ]);

        $user = Auth::user();

        // Verify password
        if (!Hash::check($this->password, $user->password)) {
            $this->addError('password', 'The password is incorrect.');
            return;
        }

        // Password is correct, show confirmation modal
        $this->showConfirmModal = true;
    }

    public function deleteAccount()
    {
        $user = Auth::user();

        // Log the user out
        Auth::logout();

        // Delete the user account
        $user->delete();

        // Invalidate session
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Redirect to home page
        return redirect('/')->with('message', 'Your account has been deleted successfully.');
    }

    public function cancelDelete()
    {
        $this->showConfirmModal = false;
        $this->reset('password');
    }

    public function render()
    {
        return view('livewire.users.settings.delete');
    }
}