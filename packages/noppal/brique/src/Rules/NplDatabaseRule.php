<?php

namespace Npl\Brique\Rules;

class NplDatabaseRule {


    public static function exists($table){
        return new \Npl\Brique\Rules\ExistsValueChange($table);
    }
}