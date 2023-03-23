<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class checkRepetitiveGroup implements Rule
{
    protected array $repetitiveGroup = ['a', 'b', 'c', 'd', 'f','g','h','i','j','k','l', 'm','n','o','z'];


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
       return in_array($value, $this->repetitiveGroup);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The Repetitive Group not found on tables declared by UsNavy REV 7 (2016).";
    }

}
