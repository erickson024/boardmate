<?php

namespace App\Livewire\Properties;

use Livewire\Component;                    //makes this a Livewire Component.
use App\Models\Property;                   //your database model for properties
use Illuminate\Support\Facades\Auth;       //gets the currently logged-in user
use Livewire\WithFileUploads;              //allows image uploads
use Illuminate\Support\Facades\Validator;  //for custom file/image validation

//class
class Register extends Component
{   
    
    use WithFileUploads;        //upload traits
    public $currentStep = 1;    //starting step


    //1st step address and mapping
    public $address, $latitude, $longitude;     //address properties
    protected $listeners = ['setAddress' => 'updateAddress']; //listeners
    //update address method
    public function updateAddress($address, $lat, $lng)
    {
        $this->address = $address;
        $this->latitude = $lat;
        $this->longitude = $lng;
    }
   

    //2nd step basic info
    public $name, $type = '', $tenant = '', $cost, $description;  //basic info properties

    //3rd step amenities
    public $amenities = [], $newAmenity = '';  //amenity properties
    public function addAmenity()   //add amenity method
    {
        $trimmed = trim($this->newAmenity);
        if ($trimmed && !in_array($trimmed, $this->amenities)) {
            $this->amenities[] = $trimmed;
        }
        $this->newAmenity = '';
    }

    public function removeAmenity($index)  //remove amenity method
    {
        unset($this->amenities[$index]);
        $this->amenities = array_values($this->amenities);
    }

    // Step 4 images
    //image properties
    public
        $images = [],
        $captions = [],
        $newImages = [],
        $imageErrors = [];

    //update image method
    public function updatedNewImages($batch)
    {
        foreach ($batch as $image) {
            $validator = Validator::make(
                ['file' => $image],
                ['file' => 'image|max:4048']
            );

            if ($validator->fails()) {
                $this->imageErrors[] = $image->getClientOriginalName() . " is not a valid image.";
            } else {
                $this->images[] = $image;
                $this->captions[] = '';
            }
        }

        // Reset input so user can re-upload the same file
        $this->newImages = [];
    }

    //remove image method
    public function removeImage($index)
    {
        unset($this->images[$index]);
        unset($this->captions[$index]);

        // Re-index arrays
        $this->images = array_values($this->images);
        $this->captions = array_values($this->captions);
    }

    //step validation rules properties
    protected $stepRules = [
        1 => [

            'address' => 'required|string|max:500',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ],

        2 => [

            'name' => 'required|string|max:255',
            'type' => 'required|in:room,bedspace,apartment,condo,house',
            'tenant' => 'required|in:student,professional,family,any',
            'cost' => 'required|numeric|min:1',
            'description' => 'required|string|max:3000',

        ],
        3 => [
            'amenities' => 'array',
            'amenities.*' => 'string|max:100',
        ],
        4 => [
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'required|image|max:4048', // each image max 4MB

            'captions' => 'nullable|array',
            'captions.*' => 'string|max:255',
        ],
    ];

    //submit method
    public function submit()
    {
        $allRules = array_merge(...array_values($this->stepRules));
        $this->validate($allRules);

        $storedImages = [];
        $storedCaptions = [];

        foreach ($this->images as $index => $image) {
            $path = $image->store('uploads', 'public');
            $storedImages[] = $path;

            // Make sure we grab the caption for this exact index
            $storedCaptions[] = $this->captions[$index] ?? '';
        }

        // Save property
        Property::create([
            'user_id'       => Auth::id(),
            'name'          => $this->name,
            'type'          => $this->type,
            'tenant'        => $this->tenant,
            'cost'          => $this->cost,
            'description'   => $this->description,
            'address'       => $this->address,
            'latitude'      => $this->latitude,
            'longitude'     => $this->longitude,
            'amenities'     => json_encode($this->amenities),
            'images'        => json_encode($storedImages),
            'captions'      => json_encode($storedCaptions), 
        ]);

        // Redirect to index page
        return redirect()->route('index');
    }

    //next step method
    public function nextStep()
    {
        // Validate only current step
        if (isset($this->stepRules[$this->currentStep])) {
            $this->validate($this->stepRules[$this->currentStep]);
        }

        if ($this->currentStep < 4) {
            $this->currentStep++;
           
            $this->dispatch('stepChanged', step: $this->currentStep);
        }
    }

    //previous step method
    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->dispatch('stepChanged', step: $this->currentStep);
        }
    }

    //render method
    public function render()
    {
        return view('livewire.properties.register');
    }
}
