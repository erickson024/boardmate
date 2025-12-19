<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class Login extends Component
{
    public $email, $password;
    public $remember = false;

    protected function rules() //validation method
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ];
    }

    private function rateLimitKey()
    {
        return 'login|' . $this->email . '|' . request()->ip();
    }

    private function hasTooManyLoginAttempts($key)
    {
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('email', "Too many attempts. Try again in $seconds seconds");
            return true;
        }
        return false;
    }

    private function redirectUserBasedOnRole($user)
    {
        return match ($user->role) {
            'admin' => $this->redirect(route('admin.dashboard'), navigate: true),
            default => $this->redirect(route('home'), navigate: true),
        };
    }

    public function login()
    {
        //validate inputs
        $this->validate();
        
        //generate a unique key for rate limiting
        $key = $this->rateLimitKey();
        
        //check if user has too many login attempts
        if ($this->hasTooManyLoginAttempts($key)) {
            return;
        }
        
        //attempt to authenticate the user
        $credentials = ['email' => $this->email, 'password' => $this->password];
        if (Auth::attempt($credentials, $this->remember)) {

            RateLimiter::clear($key);
            session()->regenerate();

          return $this->redirectUserBasedOnRole(Auth::user());

        }

        RateLimiter::hit($key, 300);
        $this->addError('email', 'The provided credentials do not match our records.');
        Log::warning("Failed login attempt for {$this->email} from IP " . request()->ip() . " using " . request()->userAgent());

    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
