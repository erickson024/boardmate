<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Livewire\Component;

class Register extends Component
{
    use WithFileUploads;

    public $currentStep = 1;

    public $avatar, $firstname, $lastname, $address, $email, $password, $password_confirmation, $terms;


    protected function rules()
    {
        $stepRules = [
            1 => [
                'avatar'    => 'nullable|image|mimes:jpg,jpeg,png,gif,webp,avif|max:10048',
                'firstname' => 'required|string|max:255',
                'lastname'  => 'required|string|max:255',
                'address'   => 'required|string|max:500',
            ],
            2 => [
                'password' => 'required|string|min:8|confirmed',
            ],
            3 => [
                'email' => 'required|email|unique:users,email',
                'terms' => 'accepted',
            ],
        ];

        return $stepRules;
    }

    public function nextStep()
    {
        $rules = $this->rules();

        if (isset($rules[$this->currentStep])) {
            $this->validate($rules[$this->currentStep]);
        }

        if ($this->currentStep < 3) {
            $this->currentStep++;
            $this->dispatch('stepChanged', $this->currentStep);
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->dispatch('stepChanged', $this->currentStep);
        }
    }

    public function submit()
    {
        // Validate everything before final submission
        $allRules = collect($this->rules())->collapse()->toArray();
        $this->validate($allRules);

        // Handle avatar upload
        $avatarPath = $this->avatar
            ? $this->avatar->store('avatars', 'public')
            : null;

        // Create user
        $user = User::create([
            'avatar'    => $avatarPath,
            'firstname' => $this->firstname,
            'lastname'  => $this->lastname,
            'address'   => $this->address,
            'email'     => $this->email,
            'password'  => Hash::make($this->password),
            'terms'     => $this->terms,
        ]);

        auth()->login($user);

        return redirect()->route('profile');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
