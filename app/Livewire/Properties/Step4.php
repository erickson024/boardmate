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
        $this->images = session('property_reg.images', []);
    }

    public function updatedNewImages()
    {
        // Validate new images
        $this->validate([
            'newImages.*' => 'image|max:2048',
        ]);

        // Merge new with existing
        $this->images = array_merge($this->images, $this->newImages);
        $this->newImages = [];

        // Enforce limit
        if (count($this->images) > 5) {
            $this->images = array_slice($this->images, 0, 5);
            $this->addError('upload_limit', 'You can upload a maximum of 5 images.');
        }
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function submit()
    {
        $this->validate();

        if (count($this->images) < 1) {
            $this->addError('images', 'Please upload at least one image.');
            return;
        }

          $savedPaths = [];
        foreach ($this->images as $image) {
            if ($image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $path = $image->store('public/property_images');
                $savedPaths[] = $path;
            } else {
                // Already a saved path
                $savedPaths[] = $image;
            }
        }

        session()->put('property_reg.images', $savedPaths);
        $this->dispatch('goToStep', 5);
    }

    public function back()  
    {
        session()->put('property_reg.images', $this->images);
        $this->dispatch('goToStep', 3);
    }

    public function render()
    {
        return view('livewire.properties.step4');
    }
}
