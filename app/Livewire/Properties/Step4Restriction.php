<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

class Step4Restriction extends Component
{
    #[Validate('required|array|min:1')]
    public array $propertyRestrictions = [];

    public array $propertyRestrictionIcons = [
        // 🚭 Lifestyle
        'No Smoking' => 'fas fa-smoking-ban',
        'No Vaping' => 'fas fa-ban-smoking',
        'No Alcohol' => 'fas fa-ban',
        'No Drugs' => 'fas fa-pills',
        // 🎉 Social Rules
        'No Parties' => 'fas fa-ban',
        'No Events' => 'fas fa-calendar-xmark',
        'No Loud Music' => 'fas fa-volume-xmark',
        // 🐾 Pets
        'No Pets' => 'fas fa-dog',
        'Small Pets Only' => 'fas fa-paw',
        // 👥 Guests
        'No Overnight Guests' => 'fas fa-user-slash',
        'Limited Visitors Only' => 'fas fa-user-clock',
        'Registration Required for Guests' => 'fas fa-id-card',
        // 🔇 Noise & Conduct
        'Quiet Hours Enforced' => 'fas fa-moon',
        'No Noise' => 'fas fa-clock',
        'Respect Neighbors' => 'fas fa-handshake',
        'Curfew Enforced' => 'fas fa-clock',
        // 🔥 Safety
        'No Cooking' => 'fas fa-fire-extinguisher',
        'No Open Flames' => 'fas fa-fire',
        'No Candles' => 'fas fa-burn',
        'No Incense' => 'fas fa-wind',
        // 🧱 Property Care
        'No Wall Drilling' => 'fas fa-screwdriver',
        'No Wall Painting' => 'fas fa-paint-roller',
        'No Furniture Rearranging' => 'fas fa-couch',
        'No Nails or Hooks' => 'fas fa-thumbtack',
        // 🧺 Usage
        'No Laundry' => 'fas fa-ban',
        'No Business Use' => 'fas fa-ban',
        'Residential Use Only' => 'fas fa-house-user',
        // 🚗 Parking
        'No Overnight Parking' => 'fas fa-parking',
        'No Commercial Vehicles' => 'fas fa-truck',
    ];

    private string $sessionKey;

    public function boot()
    {
        $this->sessionKey = "property_reg_" . auth()->id();
    }

    public function mount()
    {
        $step4Data = session()->get("{$this->sessionKey}.step4", []);
        $this->propertyRestrictions = $step4Data['propertyRestrictions'] ?? [];
    }

    public function updatedPropertyRestrictions()
    {
        // Clear validation errors when user makes a selection
        $this->resetValidation('propertyFeatures');
        $this->saveToSession();
    }

    private function saveToSession(): void
    {
        session()->put("{$this->sessionKey}.step4", [
            'propertyRestrictions' => $this->propertyRestrictions
        ]);
    }

    #[On('validationErrors')]
    public function handleValidationErrors($step, $errors)
    {
        if ($step === 4 && isset($errors['propertyRestrictions'])) {
            // Set the error on this component
            $this->addError('propertyRestrictions', $errors['propertyRestrictions'][0]);
        }
    }

    public function render()
    {
        return view('livewire.properties.step4-restriction');
    }
}
