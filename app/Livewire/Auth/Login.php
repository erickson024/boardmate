<?php

namespace App\Livewire\Auth;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return redirect()->intended('/properties'); // redirect to homepage or dashboard
        }

        $this->addError('email', 'Invalid email or password.');
    }

        public function goToDashboard()
    {

        return redirect()->route('landing'); 
    }

    public function render()
    {
        session()->forget('signup'); // remove signup progress data
        return view('livewire.auth.login');
    }
}
