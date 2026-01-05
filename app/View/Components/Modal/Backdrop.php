<?php

namespace App\View\Components\Modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Backdrop extends Component
{
    /**
     * Create a new component instance.
     */
    public string $id;
    public string $title;
    public function __construct(string $id, string $title = '')
    {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal.backdrop');
    }
}
