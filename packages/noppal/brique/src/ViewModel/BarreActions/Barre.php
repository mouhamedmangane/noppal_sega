<?php

namespace Npl\Brique\ViewModel\BarreActions;

abstract class Barre{

    public $actions;


    public function __construct(){

    }
    public function addActionBarre(Action $action){

            $this->actions[]=$actions;
    }
    public static function initBarreActions(Action $actions){
        foreach ($actions as $action) {
            $this->actions[]=$this->addActionBarre($actions);
        }
    }
}
