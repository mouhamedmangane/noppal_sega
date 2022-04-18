<?php

namespace Npl\Brique\Rules;

use Illuminate\Contracts\Validation\Rule;
use Auth;

class CheckHash implements Rule
{
    public $hashed;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($hashed)
    {
        $this->hashed=$hashed;
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
        return Auth::check($value,$this->hashed);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'l\':attribute n\'est pas correct(e)';
    }
}
