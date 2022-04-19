<?php

namespace Npl\Brique\Rules;

use Illuminate\Contracts\Validation\Rule;
use Validator;

class NplOpForm implements Rule
{
    private $form;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($form)
    {
        $this->form=$form;

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
        $tab=[];
        foreach ($this->form as $key => $val) {
            $attr=$attribute.'.'.$val;
            if($val=='op_name'){
                $tab[$attr]='required';
            }else{
                $tab[$attr]='present';
            }
            $tab[$attr]='required';

        }
        $validator = Validator::make([$attribute=>$value],$tab);
        if($validator->fails()){
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.ninterval.forme');
    }
}
