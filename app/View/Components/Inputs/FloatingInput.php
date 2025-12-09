<?php

namespace App\View\Components\inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class floatingInput extends Component
{
    /**
     * Create a new component instance.
     */

    public $id;
    public $label;
    public $model;
    public $type;

    public function __construct($id, $label, $model, $type = 'text')
    {
        $this->id = $id;
        $this->label = $label;
        $this->model = $model;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.floating-input');
    }
}
