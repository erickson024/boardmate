<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;


class Step5TenantDescription extends Component
{
    #[Validate('nullable|string|in:male,female,all')]
    public ?string $tenantGender = null;
    
    #[Validate('nullable|string|in:student,employee,family,single,2person,groups,couple,all')]
    public ?string $tenantType = null;
    

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
        '2person' => [
            'label' => '2 Person',
            'icon'  => 'fas fa-user-friends',
            'color' => 'success',
        ],
        'groups' => [
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
            'label' => 'All Types',
            'icon'  => 'fas fa-users',
            'color' => 'secondary',
        ],
    ];

    private string $sessionKey;

    public function boot()
    {
        $this->sessionKey = "property_reg_" . auth()->id();
    }

    public function mount()
    {
        $step5Data = session()->get("{$this->sessionKey}.step5", []);

        $this->fill([
            'tenantGender' => $step5Data['tenantGender'] ?? null,
            'tenantType' => $step5Data['tenantType'] ?? null,
        ]);
    }

    public function updatedTenantGender()
    {
        $this->resetValidation('tenantGender');
        $this->saveToSession();
    }

    public function updatedTenantType()
    {
        $this->resetValidation('tenantType');
        $this->saveToSession();
    }

    private function saveToSession(): void
    {
        session()->put("{$this->sessionKey}.step5", [
            'tenantGender' => $this->tenantGender,
            'tenantType' => $this->tenantType,
        ]);
    }

    #[On('validationErrors')]
    public function handleValidationErrors($step, $errors)
    {
        if ($step === 5) {
            if (isset($errors['tenantGender'])) {
                $this->addError('tenantGender', $errors['tenantGender'][0]);
            }
            if (isset($errors['tenantType'])) {
                $this->addError('tenantType', $errors['tenantType'][0]);
            }
        }
    }

    public function render()
    {
        return view('livewire.properties.step5-tenant-description');
    }
}