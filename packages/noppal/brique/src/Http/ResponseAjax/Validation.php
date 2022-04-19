<?php

namespace Npl\Brique\Http\ResponseAjax;
Use Validator;

class Validation{

    public static function validate($validator){
        return [
            'status'=>false,
            'message'=>\Npl\Brique\Util\Validation::textMessages($validator),
            "errors"=>$validator->errors()
        ];
    }

}
