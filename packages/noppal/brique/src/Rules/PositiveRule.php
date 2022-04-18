<?php

namespace Npl\Brique\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class PositiveRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
         if(!empty($value)){
            $is_not_numeric = Validator::make([$attribute=>$value],
                [$attribute=>'numeric']
            )->fails();



            return (!empty($value) && $value>0) && !$is_not_numeric;
        }
        else{
            return true;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "le champs ':attribute' n 'est pas en entier positif";
    }
}
