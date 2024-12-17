<?php

namespace App\Traits\Validation;

use App\Rules\Title;

trait HasPostFields
{
    protected function postRules(): array
    {
        return [
            'title' => ['required', 'max:100', new Title],
            'category_id' => 'required',
            'body' => 'required',
            'featured_image' => 'image | file | max:1024',
        ];
    }
}

?>