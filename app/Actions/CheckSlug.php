<?php

namespace App\Actions;

class CheckSlug
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Create a slug from the passed in parameter value
     */
    public function handle(string $string, string $separator, $comparator): string
    {
        return strtolower(preg_replace('/[^a-z]+/i', $separator, $string)) != $comparator;
    }
}
