<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step1BasicInformation extends Component
{
    public $propertyName, $propertyCost, $propertyDescription;

    public string $propertyType = '';
    public array $propertyTypes = [
        'apartment' => 'Apartment',
        'condominium'  => 'Condominium',
        'house' => 'House',
        'studio' => 'Studio',
        'dormitory' => 'Dormitory',
    ];

    public array $propertyTypeIcons = [
        'apartment'   => 'bi bi-building-fill',
        'condominium' => 'bi bi-buildings-fill',
        'house'       => 'bi bi-house-fill',
        'studio'      => 'bi bi-door-closed-fill',
        'dormitory'   => 'bi-people-fill',
    ];

    protected $rules = [
        'propertyName' => 'required|string|max:255',
        'propertyCost' => 'required|numeric|min:0',
        'propertyDescription' => 'nullable|string',
        'propertyType' => 'required|string|in:apartment,condominium,house,studio,dormitory',
    ];

    protected $listeners = [
        'validateStep1' => 'validateCurrentStep',
    ];

    public function mount()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";
        $saved = session()->get($sessionKey, []);
        $step1Data = $saved['step1'] ?? [];
        
        $this->propertyName = $step1Data['propertyName'] ?? '';
        $this->propertyCost = $step1Data['propertyCost'] ?? '';
        $this->propertyDescription = $step1Data['propertyDescription'] ?? '';
        $this->propertyType = $step1Data['propertyType'] ?? '';
    }

    public function validateCurrentStep()
    {
        $this->validate();

        // Save to session
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";
        $data = session()->get($sessionKey, []);
        
        $data['step1'] = [
            'propertyName' => $this->propertyName,
            'propertyCost' => $this->propertyCost,
            'propertyDescription' => $this->propertyDescription,
            'propertyType' => $this->propertyType,
        ];
        
        session()->put($sessionKey, $data);
        
        // Go to next step
        $this->dispatch('nextStep');
    }

    public function render()
    {
        return view('livewire.properties.step1-basic-information');
    }
}