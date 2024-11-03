<?php

namespace App\View\Components\layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class dashboardLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $page,
        public string $title,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.dashboard-layout');
    }
}
