<?php

namespace App\Livewire\Properties;

use Livewire\Component;

class Step4Restriction extends Component
{
    public array $propertyRestrictions = [];

    public array $propertyRestrictionIcons = [

        // 🚭 Lifestyle
        'No Smoking'                => 'fas fa-smoking-ban',
        'No Vaping'                 => 'fas fa-ban-smoking',
        'No Alcohol'                => 'fas fa-ban',
        'No Drugs'                  => 'fas fa-pills',

        // 🎉 Social Rules
        'No Parties'                => 'fas fa-ban',
        'No Events'                 => 'fas fa-calendar-xmark',
        'No Loud Music'             => 'fas fa-volume-xmark',

        // 🐾 Pets
        'No Pets'                   => 'fas fa-dog',
        'Small Pets Only'           => 'fas fa-paw',

        // 👥 Guests
        'No Overnight Guests'       => 'fas fa-user-slash',
        'Limited Visitors Only'     => 'fas fa-user-clock',
        'Registration Required for Guests' => 'fas fa-id-card',

        // 🔇 Noise & Conduct
        'Quiet Hours Enforced'      => 'fas fa-moon',
        'No Noise'       => 'fas fa-clock',
        'Respect Neighbors'         => 'fas fa-handshake',
        'Curfew Enforced'           => 'fas fa-clock',

        // 🔥 Safety
        'No Cooking'                => 'fas fa-fire-extinguisher',
        'No Open Flames'            => 'fas fa-fire',
        'No Candles'                => 'fas fa-burn',
        'No Incense'                => 'fas fa-wind',

        // 🧱 Property Care
        'No Wall Drilling'          => 'fas fa-screwdriver',
        'No Wall Painting'          => 'fas fa-paint-roller',
        'No Furniture Rearranging'  => 'fas fa-couch',
        'No Nails or Hooks'         => 'fas fa-thumbtack',

        // 🧺 Usage
        'No Laundry'     => 'fas fa-ban',
        'No Business Use'           => 'fas fa-ban',
        'Residential Use Only'      => 'fas fa-house-user',

        // 🚗 Parking
        'No Overnight Parking'      => 'fas fa-parking',
        'No Commercial Vehicles'    => 'fas fa-truck',
    ];

    protected $listeners = [
        'validateStep4' => 'validateCurrentStep'
    ];

    protected $rules = [
        'propertyRestrictions' => 'required|array|min:1',
    ];

    protected $messages = [
        'propertyRestrictions.required' => 'Please select at least one feature.',
        'propertyRestrictions.min' => 'Please select at least one feature.',
    ];

    public function mount()
    {
        // Load from session if exists
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";
        
        $saved = session()->get($sessionKey, []);
        $step4Data = $saved['step4'] ?? [];
        
        $this->propertyFeatures = $step4Data['propertyRestriction'] ?? [];
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
        
        // Update with step 3 data
        $data['step4'] = [
            'propertyRestrictions' => $this->propertyRestrictions,
        ];
        // Save back to session
        session()->put($sessionKey, $data);
    }

    public function render()
    {
        return view('livewire.properties.step4-restriction');
    }
}
