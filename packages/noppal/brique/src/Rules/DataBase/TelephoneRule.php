<?php

namespace Npl\Brique\Rules\DataBase;

use Illuminate\Contracts\Validation\Rule;
use Npl\Brique\Rules\PositiveRule;
use Validator,DB;

class TelephoneRule implements Rule
{

    public const ADD_METHOD=0;
    public const UPDATE_METHOD=1;

    private const IS_EXIST_NUMBER=0;
    private const IS_NOT_NUMERIC=1;


    private $code
    ;


    private $table;
    private $pour;
    /**
     * Create a new rule instance.
     *
     * method: en modification ou en creation
     * 
     * @return void
     */
    public function __construct($table="telephones",$pour=0)
    {

        $this->table=$table;
        $this->pour=$pour;
        $this->code=[];
    }

    // pour modification ou suppression

    public function setPour($pour){
        $this->pour=$pour;
        return $this;
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
        return $this->numericValidation($attribute,$value) && $this->testUnique($attribute,$value);
    }
    public function numericValidation($attribute, $value){
        $test = Validator::make([$attribute=>$value],[
            $attribute.'.indicatif'=>[new PositiveRule],
            $attribute.'.numero'=>[new PositiveRule],
            $attribute.'.id'=>[new PositiveRule],

        ])->fails();
        if($test) $this->code[]=self::IS_NOT_NUMERIC;
        return !$test;
    }

    public function testUnique($attribute,$value){
        if(!isset($value['numero']) || empty($value['numero']))
            return true;
        $test= DB::table($this->table);
        if($value['indicatif'])
            $test->where('indicatif',$value['indicatif']);
        if($value['numero'])
            $test->where('numero',$value['numero']);
        if(isset($value['id']) && !empty($value['id']))
            $test->where('id','<>',$value['id']);
        $test=$test->exists();
        //   dd($test);
        if($test) $this->code[]=self::IS_EXIST_NUMBER;
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
