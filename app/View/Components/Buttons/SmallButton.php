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
    public $action;
    public $href;
    public $variant;
    public $type;

    public function __construct($href = null, $action = null, $variant = 'dark', $type = 'button')
    {
        $this->href = $href;
        $this->action = $action;
        $this->variant = $variant;
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
