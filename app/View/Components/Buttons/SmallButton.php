<?php

namespace App\View\Components\Buttons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SmallButton extends Component
{
    /**
     * Create a new component instance.
     */
    public $type;
    public function __construct($type = 'button')
    {
         $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.buttons.small-button');
    }
}
