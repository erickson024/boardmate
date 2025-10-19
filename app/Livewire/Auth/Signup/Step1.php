<?php

namespace App\Livewire\Auth\Signup;

use Livewire\Component;

class Step1 extends Component
{
    public $firstname, $lastname, $address;
    
    protected $rules = [
        'firstname'=> 'required|string',
        'lastname'=> 'required|string',
        'address'=> 'required|string',
    ];

    public function mount()
    {
        $this->fill(session()->get('signup', []));
    }

    public function submit(){
        $this->validate();

        $signupData = session()->get('signup', []);
        $signupData = array_merge($signupData,[
              'firstname' => $this->firstname,
              'lastname' => $this->lastname,
              'address' => $this->address,
        ]);

        session()->put('signup', $signupData);
        $this->dispatch('goToStep', 2);
    }

    public function render()
    {
        return view('livewire.auth.signup.step1');
    }
}
