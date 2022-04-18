<?php

namespace Npl\Brique\Rules;

use Npl\Brique\ViewModel\Filter\LigneFilterOneMd;
use Illuminate\Contracts\Validation\Rule;

class NOp implements Rule
{
    public const NUMBER='numeric';
    public const TEXT='string';
    public const DATE='date';
    private $mes;
    private $code_error=0;//code pour
    private $type;
    /*  *
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($type)
    {
        $this->type=$type;
    }



    public function possibleOp($attribute,$value){

    }

    public function verificationType($attribute,$value){
        $validator = Validator::make([$attribute=>array_splice($value,1,count($value)-1)], [
                ($attribute.'.*') => $this->type
        ]);
        if($validator->fails()){
            $this->code_error=4;
            return false;
        }
        return true;
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
        $formOp=['op_name','valeur'];
        $possible_op=LigneFilterOneMd::POSSIBLE_OPS;
        $message=NplValidator::oneByOne($attribute,$value,[
            new NplOpForm($formOp),
            new NplOPPossible($value[$formOp[0]],$possible_op),
            new NplOpType($this->type,[$formOp[0]])

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
