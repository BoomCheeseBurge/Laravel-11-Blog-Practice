<?php

namespace App\Traits\Validation;

use App\Rules\Fullname;
use App\Rules\MaxCharacter;

trait HasUserFields
{
    protected function userRules(): array
    {
        return [
            'fullname' => ['required', 'max:255', new Fullname],
            'profile_pic' => 'nullable | image | mimes:png,jpeg,jpg | max:1024',
            'profile_cover' => 'nullable | image | mimes:png,jpeg,jpg | max:2048',
            'about' => ['nullable', 'ascii', new MaxCharacter(200)],
        ];
    }
}

?>