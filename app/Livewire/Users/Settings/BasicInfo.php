<?php

namespace App\Livewire\Users\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BasicInfo extends Component
{
    public $firstName;
    public $lastName;

    public function mount()
    {
        $user = Auth::user();
        $this->firstName = $user->firstName;
        $this->lastName = $user->lastName;
    }

    protected function rules()
    {
        return [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
        ];
    }

    public function updateBasicInfo()
    {
        $this->validate();

        $user = Auth::user();
        $user->update([
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ]);

        session()->flash('message', 'Information updated successfully!');
        
        // Optional: emit event to parent or refresh
        $this->dispatch('user-updated');
    }

    public function render()
    {
        return view('livewire.users.settings.basic-info');
    }
}