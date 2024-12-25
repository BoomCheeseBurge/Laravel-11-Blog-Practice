<?php

namespace App\Traits\Livewire;

use Illuminate\Support\Facades\Gate;

trait WithAuthorization
{
    public function mountWithAuthorization()
    {
        Gate::authorize('admin');
    }
}
