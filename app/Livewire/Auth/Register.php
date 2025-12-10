<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class Register extends Component
{
    //property
    public        
    $firstName, 
    $lastName, 
    $email, 
    $password, 
    $passwordConfirmation, 
    $terms = false, 
    $role = 'tenant',
    $profile_image = null;

    //validation rule
    protected function rules()
    {
        return[
           'firstName' => 'required|string|max:255',
           'lastName'  => 'required|string|max:255',
           'email'     => 'required|email|unique:users,email',
           'password'  => 'required|min:8',
           'passwordConfirmation' => 'required|same:password',
           'terms' => 'accepted',
        ];
    }
    
    //property for password
    public $strengthScore = 0;

    // Livewire hook for password updates
    public function updatedPassword($value) 
    {
        $this->checkStrength($value);
    }  

    // Simple password strength checker
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

    public function register()
    {
        //checks all rules
        $this->validate();  

        if ($this->strengthScore < 4) {
            $this->addError('password', 'Add uppercase letters, numbers, or special characters to make it stronger.');
            return;
        }
        
         //eloquent
        $user = User::create([                      
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'terms' => $this->terms ? 'accepted' : 'not accepted',
            'role' => $this->role,
            'profile_image' => $this->profile_image
        ]);
        
        auth()->login($user);  //create session
        event(new Registered($user)); //for email verification
        return redirect()->route('verification.notice');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
