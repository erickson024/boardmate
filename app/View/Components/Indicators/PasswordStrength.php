<?php

namespace App\View\Components\Indicators;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PasswordStrength extends Component
{
    /**
     * Create a new component instance.
     */
    public int $strengthScore;
    public function __construct(int $strengthScore = 0)
    {
        $this->strengthScore = $strengthScore;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.indicators.password-strength');
    }
}
