<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProfileImage extends Component
{
    /**
     * Create a new component instance.
     */
    public $image;
    public $firstName;
    public $lastName;
    public $size;
    public function __construct($image = null, $firstName = null, $lastName = null, $size = 80)
    {
        $user = auth()->user(); 

        $this->image = $image ?? $user?->profile_image;
        $this->firstName = $firstName ?? $user?->firstName;
        $this->lastName = $lastName ?? $user?->lastName;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile-image');
    }
}
