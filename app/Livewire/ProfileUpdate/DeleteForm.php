<?php

namespace App\Livewire\ProfileUpdate;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DeleteForm extends Component
{
    public $password;

    protected $rules = [
        'password' => 'required',
    ];

    public function deleteAccount()
    {
        $this->validate();

        $user = Auth::user();

        // verify password
        if (!Hash::check($this->password, $user->password)) {
            $this->addError('password', 'The password is incorrect.');
            return;
        }

        Auth::logout();

        $user->delete();

        session()->invalidate();
        session()->regenerateToken();

        return redirect('/'); // or wherever you want after account deletion
    }

    public function render()
    {
        return view('livewire.profile-update.delete-form');
    }
}
