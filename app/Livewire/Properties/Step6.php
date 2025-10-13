<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use App\Models\Property; // Make sure this is your Property model
use Illuminate\Support\Facades\Auth;

class Step6 extends Component
{
    public $terms, $payment, $agree;

    protected $rules = [
        'terms' => 'nullable|string|max:255',
        'payment' => 'nullable|string|max:255',
        'agree' => 'accepted',
    ];

    public function mount()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        // Load previously saved data from session
        $this->fill(
            data_get(session($sessionKey), 'policies', [])
        );
    }

    public function submit()
    {
         $this->validate();

        $user_id = Auth::id();
        $sessionKey = "property_reg_{$user_id}";

        // Merge the policies into the session
        $allData = array_merge(session()->get($sessionKey, []), [
            'policies' => [
                'terms' => $this->terms,
                'payment' => $this->payment,
                'agree' => $this->agree,
            ],
        ]);

        session()->put($sessionKey, $allData);

        // Save to database
        $property = new Property();

        $property->user_id = $user_id;
        $property->name = $allData['name'] ?? null;
        $property->cost = $allData['cost'] ?? null;
        $property->type = $allData['type'] ?? null;
        $property->description = $allData['description'] ?? null;
        $property->address = $allData['address'] ?? null;
        $property->latitude = $allData['latitude'] ?? null;
        $property->longitude = $allData['longitude'] ?? null;

        $property->feature = json_encode($allData['features'] ?? []);
        $property->images = json_encode($allData['images'] ?? []);

        // Tenant info
        $tenant = $allData['tenant'] ?? [];
        $property->tenantType = $tenant['tenantType'] ?? null;
        $property->tenantGender = $tenant['tenantGender'] ?? null;
        $property->tenantRestriction = $tenant['tenantRestriction'] ?? null;

        // Policies
        $policies = $allData['policies'] ?? [];
        $property->terms = $policies['terms'] ?? null;
        $property->payment = $policies['payment'] ?? null;
        $property->agree = $policies['agree'] ?? false;

        $property->save();

        // Optionally clear session after saving
        session()->forget($sessionKey);

        // Redirect or show success
        session()->flash('success', 'Property successfully uploaded!');
        return $this->redirect('/user-property-list', navigate: true);
    }
  
    public function back()
    {
        $this->dispatch('goToStep', 5);
    }
    public function render()
    {
        return view('livewire.properties.step6');
    }
}
