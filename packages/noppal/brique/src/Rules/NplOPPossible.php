<?php

namespace Npl\Brique\Rules;

use Illuminate\Contracts\Validation\Rule;

class NplOPPossible implements Rule
{
    private $possible_ops;
    private $op;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($op,$possible_ops)
    {
        $this->op=$op;
        $this->possible_ops = $possible_ops;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if(in_array($this->op,$this->possible_ops)){
            return true;
            
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.ninterval.operation');
    }
}
