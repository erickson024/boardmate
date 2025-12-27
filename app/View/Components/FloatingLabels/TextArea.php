<?php

namespace App\View\Components\FloatingLabels;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextArea extends Component
{
    /**
     * Create a new component instance.
     */
    public $id;
    public $label;
    public $height;

    public function __construct($id, $label, $height = 100)
    {
        $this->id = $id;
        $this->label = $label;
        $this->height = $height;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.floating-labels.text-area');
    }
}
