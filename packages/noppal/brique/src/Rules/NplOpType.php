<?php

namespace Npl\Brique\Rules;

use Illuminate\Contracts\Validation\Rule;
use Validator;

class NplOpType implements Rule
{
    public $type;
    private $excepted_attr;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($type_control,$excepted_attr)
    {
        $this->type= $type_control;
        $this->excepted_attr=$excepted_attr;
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
        $validated=true;
        $aVerifier=[];
        foreach($value as $key => $val){
            if(!in_array($key,$this->excepted_attr) && !empty($val)){
                $aVerifier[$key]=$val;
            }
        }
        // echo var_dump($value);
        // echo var_dump($aVerifier);
        //die;
        $validator = Validator::make([$attribute=>$aVerifier], [
            ($attribute.'.*') => $this->type,
        ]);
        if($validator->fails()){
            $validated=false;
        }
        return $validated;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.ninterval.'.$this->type);
    }
}
