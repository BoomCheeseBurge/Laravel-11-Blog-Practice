<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxCharacter implements ValidationRule
{
    public int $maxCount;

    /**
     * Create a new rule instance.
     *
     * @param $param
     */
    public function __construct($param)
    {
        $this->maxCount = $param;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Ensure that the input has words no longer than the specified number of characters
        if (str_word_count($value) > $this->maxCount) {
            $fail('The text must not exceed more than '. $this->maxCount .' words.');
        }
    }
}
