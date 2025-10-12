<?php

namespace App\Livewire\Properties;

use Livewire\Component;
use Livewire\WithFileUploads;

class Step4 extends Component
{
    use WithFileUploads;

    public $images = [];
    public $newImages = [];

    protected $rules = [
        'images' => 'array|max:5',
        'images.*' => 'image|max:2048',
        'newImages.*' => 'image|max:2048'
    ];

    public function mount()
    {
        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        // Load previously saved images from session
        $this->images = session()->get("{$sessionKey}.images", []);
    }

    public function updatedNewImages()
    {
        foreach ($this->newImages as $file) {
            $path = $file->store('tmp', 'public');
            $this->images[] = $path;
        }

        $this->newImages = [];
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function submit()
    {
        // Only validate newImages
        $this->validate([
            'newImages.*' => 'image|max:2048',
        ]);

        if (count($this->images) < 1) {
            $this->addError('images', 'Please upload at least one image.');
            return;
        }

        $user_id = auth()->id();
        $sessionKey = "property_reg_{$user_id}";

        $savedPaths = [];
        foreach ($this->images as $image) {
            if ($image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $path = $image->store('property_images', 'public');
                $savedPaths[] = $path;
            } else {
                $savedPaths[] = $image;
            }
        }

         // Save images under the unified session key
        session()->put("{$sessionKey}.images", $savedPaths);
        $this->dispatch('goToStep', 5);
    }


    public function back()
    {

        if (count($this->images) < 1) {
            $this->addError('images', 'Please upload at least one image.');
            return;
        }

        $savedPaths = [];
        foreach ($this->images as $image) {
            if ($image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $path = $image->store('property_images', 'public');
                $savedPaths[] = $path;
            } else {
                // Already a saved path
                $savedPaths[] = $image;
            }
        }
        session()->put('property_reg.images', $savedPaths);
        $this->dispatch('goToStep', 3);
    }

    public function render()
    {
        return view('livewire.properties.step4');
    }
}
