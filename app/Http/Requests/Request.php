<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Merge the trait rules to the current rules in the validator
     * 
     * @param  \Illuminate\Validation\Validator  $validator
     * @return array
     */
    public function withValidator(Validator $validator)
    {
        if ($rules = $this->getTraitRules()) {
            $validator->addRules($rules);
        }
    }

    /**
     * Ensure the trait name corresponds to the expected rule method name  
     * 
     * @return array
     */
    protected function getTraitRules(): array
    {
        return array_reduce(class_uses(static::class), function ($rules, $trait) {
            $rulesMethod = $this->makeRulesMethodName($trait);

            if ($rulesMethod && method_exists($this, $rulesMethod)) {
                // If the trait name matches our convention and a <name>Rules
                // method exists, merge the result into our rules array.
                $rules = array_merge($rules, $this->{$rulesMethod}());
            }

            return $rules;
        }, []);
    }

    /**
     * Convert the trait name to its equivalent rule method name
     * 
     * @param  string  $trait
     * @return string
     */
    protected function makeRulesMethodName($trait)
    {
        preg_match('/^Has([A-Za-z]+)Fields$/', class_basename($trait), $matches);

        // If the trait matches our `Has<name>Fields` convention, get the 
        // <name> part, camelCase it and attach 'Rules' at the end.
        return isset($matches[1]) ? ucwords($matches[1]).'Rules' : null;
    }
}
