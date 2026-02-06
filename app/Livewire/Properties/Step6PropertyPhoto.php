<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\WithFileUploads;


class Step6PropertyPhoto extends Component
{
    use WithFileUploads;

    public array $images = [];
    public array $storedImages = [];
    public $uploadProgress = 0; // ADD THIS LINE - it was missing!

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
        // FIX: Same pattern as other steps
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

    private function saveToSession(): void
    {
        // FIX: Same pattern as other steps
        $allData = session()->get($this->sessionKey, []);
        $allData['step6'] = ['images' => $this->storedImages];
        session()->put($this->sessionKey, $allData);
    }

    public function render()
    {
        return view('livewire.properties.step6-property-photo');
    }
}