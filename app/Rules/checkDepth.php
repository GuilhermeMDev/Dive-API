<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class checkDepth implements Rule
{
    protected $depthMin;
    protected $depthMax;

    public function __construct($depthMin, $depthMax)
    {
        $this->depthMin = $depthMin;
        $this->depthMax = $depthMax;
    }

    public function passes($attribute, $value)
    {
        return $value >= $this->depthMin && $value <= $this->depthMax;
    }

    public function message()
    {
        return "The depth must be between {$this->depthMin} e {$this->depthMax}, declared by UsNavy REV 7 (2016).";
    }

}
