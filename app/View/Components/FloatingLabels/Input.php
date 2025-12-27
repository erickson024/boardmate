<?php

namespace App\View\Components\FloatingLabels;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public $id;
    public $label;
    public $type;

    public function __construct($id, $label, $type = 'text')
    {
        $this->id = $id;
        $this->label = $label;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.floating-labels.input');
    }
}
