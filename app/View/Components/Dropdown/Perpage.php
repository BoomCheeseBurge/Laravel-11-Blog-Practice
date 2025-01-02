<?php

namespace App\View\Components\Dropdown;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Perpage extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public int $perPage,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown.perpage');
    }
}
