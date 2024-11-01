<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Username implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match_all('/^[\p{L}\p{M}\p{P}]+(?:\s[\p{L}\p{M}\p{P}]+)*$/gm', $value)) {
            $fail('The :attribute must only contain alphanumeric and single whitespace characters.');
        }
    }
}
