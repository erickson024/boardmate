<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class Login extends Component
{
    public $email, $password;
    public $remember = false;

    protected function rules() //validation method
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function login()
    {
        $this->validate();   //validate inputs based on rules method

        $key = 'login' . $this->email . '|' . request()->ip();  //throttling is based on same email and IP address

        if(RateLimiter::tooManyAttempts($key, 5))    //maximum attemps
        {
           $seconds = RateLimiter::availableIn($key);
           $this->addError('email', "Too many attempts. Try again in $seconds seconds");
           return;
        }

        if(Auth::attempt($this->only(['email','password']), $this->remember)) //if validation is success also adding remember me token
        {
            RateLimiter::clear($key);

            session()->regenerate();

            $user = Auth::user();

            //role-based redirect
            if($user->role === 'admin'){
                return $this->redirect(route('admin.dashboard'), navigate: true);
            }
            return $this->redirect(route('home'), navigate: true);
        }

        RateLimiter::hit($key, 60);
        $this->addError('email', 'The provided credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
