<?php

namespace App\Livewire\Auth\Signup;

use Livewire\Component;

class Step2 extends Component
{
    public $password, $confirmPassword, $strengthScore = 0;

    protected $rules = [
        'password' => 'required|min:8',
        'confirmPassword' => 'required|same:password',
    ];

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

     public function mount()
    {
        $this->fill(session()->get('signup', []));

        // if password already exists in session, recalc strength
        if (!empty($this->password)) {
            $this->checkStrength($this->password);
        }
    }

    public function submit()
    {
        $this->validate();

        if ($this->strengthScore < 4) {
            $this->addError('password', 'Password is too weak. Please make it stronger.');
            return;
        }

        $signupData = session()->get('signup', []);
        $signupData = array_merge($signupData, [
            'password' => $this->password,
            'confirmPassword' => $this->confirmPassword,
        ]);

         session()->put('signup', $signupData);
        $this->dispatch('goToStep', 3);
    }

    public function back()
    {
        $this->dispatch('goToStep', 1);
    }

    public function render()
    {
        return view('livewire.auth.signup.step2');
    }
}
