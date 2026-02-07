<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class Step6PropertyPhoto extends Component
{
    use WithFileUploads;

    public array $images = [];
    public array $storedImages = [];
    public $uploadProgress = 0;

    protected $rules = [
        'images' => 'array|max:5',
        'images.*' => 'image|mimes:jpeg,png,webp|max:2048',
    ];

    private string $sessionKey;

    public function boot()
    {
        $this->sessionKey = "property_reg_" . auth()->id();
    }

    public function mount()
    {
        $allData = session()->get($this->sessionKey, []);
        $step6Data = $allData['step6'] ?? [];
        $this->storedImages = $step6Data['images'] ?? [];
    }

    public function updatedImages()
    {
        $this->validate(['images.*' => 'image|mimes:jpeg,png,webp|max:2048']);

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
        $this->resetErrorBag();
    }

    public function removeImage(int $index)
    {
        unset($this->storedImages[$index]);
        $this->storedImages = array_values($this->storedImages);
        $this->saveToSession();
        $this->resetErrorBag();
    }

    // ADD: Consistent validation error handling
    #[On('validationErrors')]
    public function handleValidationErrors($step, $errors)
    {
        // Only handle errors for this step
        if ($step !== 6) return;

        // Add errors to this component
        foreach ($errors as $field => $messages) {
            $this->addError($field, is_array($messages) ? $messages[0] : $messages);
        }
    }

    private function saveToSession(): void
    {
        $allData = session()->get($this->sessionKey, []);
        $allData['step6'] = ['images' => $this->storedImages];
        session()->put($this->sessionKey, $allData);
    }

    public function render()
    {
        return view('livewire.properties.step6-property-photo');
    }
}