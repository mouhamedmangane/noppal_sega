<?php

namespace Npl\Brique\Util;

class Validation {

    public static function textMessages($validator){
        $message=self::assembler($validator->errors()->getMessages());

        return $message;

    }

    public static function assembler($messages){
        $message="";
        if(is_array($messages)){
            foreach($messages as $mes){
                $message.=self::assembler($mes);
            }
        }
        else{
            $message.=$messages.' <br>';
        }
        return $message;
    }
}
