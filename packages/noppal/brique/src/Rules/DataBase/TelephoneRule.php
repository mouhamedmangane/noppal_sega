<?php

namespace Npl\Brique\Rules\DataBase;

use Illuminate\Contracts\Validation\Rule;
use Validator;

class TelephoneRule implements Rule
{

    public const ADD_METHOD=0;
    public const UPDATE_METHOD=1;

    private const IS_EXIST_NUMBER=0;
    private const IS_NOT_NUMERIC=1;


    private $code
    ;


    private $table;
    private $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table="telephones",$id=0)
    {
        $this->table=$table;
        $this->id=$id;
        $this->code=[];
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
        return $this->numericValidation() && $this->testUnique();
    }
    public function numericValidation($attribute, $value){
        $validator = Validator::make([$attribute=>$value],[
            $attribute.'.indicatif'=>'numeric',
            $attribute.'.numero'=>'numeric',
            $attribute.'.id'=>'numeric',

        ]);
        $this->code[]=self::IS_NOT_NUMERIC;
        return !$validator->fails();
    }

    public function testUnique($attribute,$value){
        $test= DB::table($this->telephone)->where('indicatif',$value->indicatif)
        ->where('numero',$value->numero)
        ->where('id','<>',$value->id)
        ->exists();
        $this->code[]=self::IS_EXIST_NUMBER;
        return !$test;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if(in_array(self::IS_EXIST_NUMBER,$this->code)){
            return "le numero de telephone :attribute existe déja";
        }
        elseif(in_array(self::IS_NOT_NUMERIC,$this->code)){
            return "les champs de :attribute doit être numerique";
        }
        else{
            return "numero de telephone invalide";
        }
    }
}
