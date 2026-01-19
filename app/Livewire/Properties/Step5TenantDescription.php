<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step5TenantDescription extends Component
{
    public string $tenantGender = '';
    public array $genders = [
        'male' => [
            'label' => 'Male',
            'icon'  => 'fas fa-mars',
            'color' => 'text-primary',
        ],
        'female' => [
            'label' => 'Female',
            'icon'  => 'fas fa-venus',
            'color' => 'text-danger',
        ],
        'all' => [
            'label' => 'All Genders',
            'icon'  => 'fas fa-venus-mars',
            'color' => 'text-secondary',
        ],
    ];

    public string $tenantType = '';
    public array $types = [
        'student' => [
            'label' => 'Student',
            'icon'  => 'fas fa-graduation-cap',
            'color' => 'primary',
        ],
        'employee' => [
            'label' => 'Employee',
            'icon'  => 'fas fa-briefcase',
            'color' => 'success',
        ],
        'family' => [
            'label' => 'Family',
            'icon'  => 'fas fa-home',
            'color' => 'warning',
        ],
        'single' => [
            'label' => 'Single',
            'icon'  => 'fas fa-user',
            'color' => 'info',
        ],
        'duo'        => [
            'label' => '2 persons',
            'icon'  => 'fas fa-user-friends',
            'color' => 'success',
        ],
        'groups'      => [
            'label' => 'Groups',
            'icon'  => 'fas fa-users',
            'color' => 'danger',
        ],
        'couple' => [
            'label' => 'Couple',
            'icon'  => 'fas fa-heart',
            'color' => 'danger',
        ],
        'all' => [
            'label' => 'All',
            'icon'  => 'fas fa-users',
            'color' => 'secondary',
        ],
    ];

    protected $listeners = [
        'validateStep5' => 'validateCurrentStep'
    ];

    protected $rules = [
        'tenantGender' => 'required|string|in:male,female,all',
        'tenantType'   => 'required|string|in:student,employee,family,single,duo,groups,couple,all'
    ];

    public function mount()
    {
        // Load from session if exists
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";
        
        $saved = session()->get($sessionKey, []);
        $step5Data = $saved['step5'] ?? [];
        
        $this->tenantDescription = $step5Data['tenantDescription'] ?? [];
    }

    public function validateCurrentStep()
    {
        $this->validate();

        // Save to session before moving to next step
        $this->saveToSession();
        
        // If validation passes, go to next step
        $this->dispatch('nextStep');
    }

    private function saveToSession()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        // Get existing session data
        $data = session()->get($sessionKey, []);
        
        // Update with step 5 data
        $data['step5'] = [
            'tenantGender' => $this->tenantGender,
            'tenantType' => $this->tenantType
        ];
    
        // Save back to session
        session()->put($sessionKey, $data);
    }

    public function render()
    {
        return view('livewire.properties.step5-tenant-description');
    }
}
