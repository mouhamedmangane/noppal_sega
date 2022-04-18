<?php

namespace Npl\Brique\Rules;

use Validator;

class NplValidator{
    static function oneByOne($attribute,$value,Array $arrayValidator){
        $params=[$attribute=>$value];
        foreach($arrayValidator as $item){
            $validator=Validator::make(
                $params,
                [$attribute=>$item]
            );
            if($validator->fails()){
                $messages=$validator->errors();
                //var_dump($validator);
                //die;
                return $messages->toArray();
            }

        }
        return null;
    }
}