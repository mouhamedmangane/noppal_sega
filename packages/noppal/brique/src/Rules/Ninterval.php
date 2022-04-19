<?php

namespace Npl\Brique\Rules;
use Npl\Brique\ViewModel\Filter\LigneFilterIntervalMd;

use Illuminate\Contracts\Validation\Rule;
use Validator;

class Ninterval implements Rule
{
    public const NUMBER='numeric';
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

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $formOp=['op_name','max','min'];
        $possible_op=LigneFilterIntervalMd::POSSIBLE_OPS;
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

        // $validated=true;
        // $keys = array_keys($value);
        // $keys_control=['op_name','max','min'];
        // for ($i=0; $i < count($keys) ; $i++) {
        //     if($keys_control[$i] != $keys[$i]){
        //         $this->code_error=$i;
        //         $validated = false;
        //         break;
        //     }
        // }
        // if($validated && !in_array($value['op_name'],LigneFilterIntervalMd::POSSIBLE_OPS)){
        //     $this->code_error=3;
        //     $this->validated=false;
        // }
        // else {
        //     $validator = Validator::make([$attribute=>$value], [

        //         ($attribute.'.min') => $this->type,
        //         ($attribute.'.max') => $this->type,
        //     ]);
        //     if($validator->fails()){
        //         $validated=false;
        //         $this->code_error=4;
        //     }
        // }
        // if($validated && $value['min'] > $value['max']){
        //     $validated=false;
        //     $this->code_error=5;
        // }
        // return $validated;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // $message= $this->code_error."";
        // switch($this->code_error){
        //     case 0: case 1: case 2:
        //         $message .= trans('validation.custom.ninterval.forme');
        //         break;
        //     case 3:
        //         $message .= trans('validation.custom.ninterval.operation');
        //         break;
        //     case 4:
        //         $message .= trans('validation.custom.ninterval.'.$this->type);
        //         break;
        //     case 5:
        //         $message .= trans('validation.custom.ninterval.maxInferieur');
        //         break;
        // }
        // return $message;
        return $this->mes;
    }
}
