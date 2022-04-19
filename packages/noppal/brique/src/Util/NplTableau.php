<?php

namespace Npl\Brique\Util;

class NplTableau {

    public static function choisirParString(Array $array,string $chaine){
        return NplString::numeriserEntre($chaine,count($array));
    }
}