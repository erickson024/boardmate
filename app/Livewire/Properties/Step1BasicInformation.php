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
    
    //just icons
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

    public function mount()
    {
        $this->fill(session()->get('propertyRegistration', []));
    }

    public function submit()
    {
        $this->validate();
        
        $propertyData = session()->get('propertyRegistration', []);
        $propertyData = array_merge($propertyData, [
            'propertyName' => $this->propertyName,
            'propertyCost' => $this->propertyCost,
            'propertyDescription' => $this->propertyDescription,
            'propertyType' => $this->propertyType,
        ]);
 
        session()->put('propertyRegistration', $propertyData);
        $this->dispatch('goToStep', 2);  
    }

    public function render()
    {
        return view('livewire.properties.step1-basic-information');
    }
}
