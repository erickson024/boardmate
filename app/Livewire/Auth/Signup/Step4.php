<?php

namespace App\Livewire\Auth\Signup;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\User;

class Step4 extends Component
{
    public $email;
    public $terms = false;

    public $rules = [
        'email' => 'required|email|unique:users,email',
        'terms' => 'accepted',
    ];

    public function mount()
    {
        $this->fill(session()->get('signup', []));
    }

    public function saveData()
    {
        $signupData = session()->get('signup', []);
        $signupData = array_merge($signupData, [
            'email' => $this->email,
            'terms' => $this->terms,
        ]);
        session()->put('signup', $signupData);
    }

    public function submit(){
       $this->validate();
       $this->saveData();
       $signupData = session()->get('signup', []);
       
       $user = User::create([
           'firstname' => $signupData['firstname'] ?? null,
            'lastname'  => $signupData['lastname'] ?? null,
            'address'    => $signupData['address'] ?? null,
            'email'      => $signupData['email'],
            'password'   => Hash::make($signupData['password']),
            'terms'      => $signupData['terms'] ?? false,
            'profile_photo'  => $signupData['profile_photo'] ?? null,
       ]);
        
        session()->forget('signup');
        auth()->login($user);
        event(new Registered($user));
        return redirect()->route('verification.notice');
    }

    public function back()
    {
        $this->saveData();
        $this->dispatch('goToStep', 3);
    }

    public function render()
    {
        return view('livewire.auth.signup.step4');
    }
}
