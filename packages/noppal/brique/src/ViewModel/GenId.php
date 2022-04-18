<?php
namespace Npl\Brique\ViewModel;

class GenId{
    static $id=0;
    static function getId(){
        return self::$id;
    }
    static function newId(){
        self::$id ++;
        return "cz".self::$id;
    }
}