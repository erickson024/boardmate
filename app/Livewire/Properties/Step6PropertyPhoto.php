<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\WithFileUploads;

class Step6PropertyPhoto extends Component
{
    use WithFileUploads;

    public array $images = [];
    public array $storedImages = [];
    public $uploadProgress = 0;

    protected $listeners = [
        'validateStep6' => 'validateCurrentStep'
    ];

    protected $rules = [
        'images'   => 'array|max:5',
        'images.*' => 'image|mimes:jpeg,png,webp|max:2048',
    ];

    protected $messages = [
        'images.max' => 'You can upload up to 5 images only.',
        'images.*.image' => 'Only image files are allowed.',
        'images.*.mimes' => 'Images must be JPEG, PNG, or WEBP format.',
        'images.*.max' => 'Each image must not exceed 2MB.',
    ];

    public function mount()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        $saved = session()->get($sessionKey, []);
        $this->storedImages = $saved['step6']['images'] ?? [];
    }

    public function updatedImages()
    {
        // Validate before processing
        $this->validate([
            'images.*' => 'image|mimes:jpeg,png,webp|max:2048'
        ]);

        // Check if adding these images would exceed limit
        $totalImages = count($this->storedImages) + count($this->images);
        if ($totalImages > 5) {
            $this->addError('images', 'Cannot upload more than 5 images total.');
            $this->images = [];
            return;
        }

        foreach ($this->images as $image) {
            $path = $image->store('property-images/tmp', 'public');
            $this->storedImages[] = $path;
        }

        $this->images = [];
        $this->saveToSession();

        // Clear any previous errors
        $this->resetErrorBag();

        // Dispatch success event (optional - for toast notifications)
        $this->dispatch('imageUploaded', count: count($this->storedImages));
    }

    public function removeImage(int $index)
{
    unset($this->storedImages[$index]);
    $this->storedImages = array_values($this->storedImages);
    $this->saveToSession();
    $this->resetErrorBag();
    // Remove this line: $this->dispatch('image-deleted');
}

    public function validateCurrentStep()
    {
        if (count($this->storedImages) < 1) {
            $this->addError('images', 'Please upload at least one image of your property.');
            return;
        }

        $this->saveToSession();
        $this->dispatch('nextStep');
    }

    private function saveToSession()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        $data = session()->get($sessionKey, []);
        $data['step6'] = [
            'images' => $this->storedImages,
        ];

        session()->put($sessionKey, $data);
    }

    public function render()
    {
        return view('livewire.properties.step6-property-photo');
    }
}
