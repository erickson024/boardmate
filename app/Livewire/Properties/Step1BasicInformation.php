<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;


class Step1BasicInformation extends Component
{
    #[Validate('required|string|max:255')]
    public $propertyName = '';

    #[Validate('required|numeric|min:0|max:999999999')]
    public $propertyCost = '';

    #[Validate('required|string|max:1000')]
    public $propertyDescription = '';

    #[Validate('required|string|in:apartment,condominium,house,studio,dormitory,bedspace')]
    public string $propertyType = '';

    public const PROPERTY_TYPES = [
        'apartment' => 'Apartment',
        'condominium' => 'Condominium',
        'house' => 'House',
        'studio' => 'Studio',
        'dormitory' => 'Dormitory',
        'bedspace' => 'Bedspace'
    ];

    public const PROPERTY_TYPE_ICONS = [
        'apartment' => 'bi bi-building-fill',
        'condominium' => 'bi bi-buildings-fill',
        'house' => 'bi bi-house-fill',
        'studio' => 'bi bi-door-closed-fill',
        'dormitory' => 'bi-people-fill',
        'bedspace' => 'bi bi-person-standing'
    ];

    private string $sessionKey;

    public function boot()
    {
        $this->sessionKey = "property_reg_" . auth()->id();
    }

    public function mount()
    {
        $allData = session()->get($this->sessionKey, []);
        $step1Data = $allData['step1'] ?? [];

        $this->fill([
            'propertyName' => $step1Data['propertyName'] ?? '',
            'propertyCost' => $step1Data['propertyCost'] ?? '',
            'propertyDescription' => $step1Data['propertyDescription'] ?? '',
            'propertyType' => $step1Data['propertyType'] ?? '',
        ]);
    }

    // FIX: Save on every update (parameter name doesn't matter)
    public function updated($name, $value)
    {
        // Validate only the field that changed
        $this->validateOnly($name);

        // Save ALL fields to session
        $this->saveToSession();
    }

    #[On('validationErrors')]
    public function handleValidationErrors($step, $errors)
    {
        // Only handle errors for this step
        if ($step !== 1) return;

        // Add errors to this component
        foreach ($errors as $field => $messages) {
            $this->addError($field, is_array($messages) ? $messages[0] : $messages);
        }
    }

    private function saveToSession(): void
    {
        $allData = session()->get($this->sessionKey, []);

        $allData['step1'] = [
            'propertyName' => $this->propertyName,
            'propertyCost' => $this->propertyCost,
            'propertyDescription' => $this->propertyDescription,
            'propertyType' => $this->propertyType,
        ];

        session()->put($this->sessionKey, $allData);
    }

    public function render()
    {
        return view('livewire.properties.step1-basic-information');
    }
}
