<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;
    public $strengthScore = 0;

    public function updatedPassword($value)
    {
        $this->checkStrength($value);
    }
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

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request('email');

        $this->fill(session()->get('signup', []));

        // if password already exists in session, recalc strength
        if (!empty($this->password)) {
            $this->checkStrength($this->password);
        }
    }

    public function resetPassword()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($this->strengthScore < 4) {
            $this->addError('password', 'Password is too weak. Please make it stronger.');
            return;
        }

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('message', 'Password has been reset successfully.');
        }

        session()->flash('error', __($status));
    }


    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
