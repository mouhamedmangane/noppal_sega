<?php

namespace Npl\Brique\Util;

class NplString {

    public static function numeriser(String $chaine){
        $numero=0;
        
        for($i=0;$i<strlen($chaine);$i++){
            $numero = ord($chaine[$i]);
        }

        return $numero;
    }

    public static function numeriserEntre(String $chaine,int $limit){
        $numero=self::numeriser($chaine);

        return $numero % $limit;
    }
}