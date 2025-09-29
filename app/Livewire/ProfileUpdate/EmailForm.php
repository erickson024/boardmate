<?php

namespace App\Livewire\ProfileUpdate;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EmailForm extends Component
{
    public $email;

    protected function rules()
    {
        return [
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ];
    }

    public function mount()
    {
        $this->email = Auth::user()->email;
    }

    public function updateEmail()
    {
        $this->validate();

        $user = Auth::user();
        if ($user->email !== $this->email) {
            $user->email = $this->email;
            $user->email_verified_at = null;
            $user->save();

            session()->flash('success', 'Email updated successfully. Please verify your new email.');
        } else {
            session()->flash('success', 'No changes made to email.');
        }
    }

    public function render()
    {
        return view('livewire.profile-update.email-form');
    }
}
