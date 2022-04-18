<?php

namespace Npl\Brique\Rules;

use App\View\Components\Generic\Filters\LigneFilterSelect;
use Illuminate\Contracts\Validation\Rule;

class NSelect implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $formOp=['op_name','op'];
        $message=NplValidator::oneByOne($attribute,$value,[
            new NplOpForm($formOp),
            new NplOpType('array',[$formOp[0]])

        ]);
        if($message==null){
            return true;
        }
        else{
            $this->mes=$message;
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->mes;
    }
}
