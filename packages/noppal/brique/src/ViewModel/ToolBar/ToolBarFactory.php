<?php

namespace Npl\Brique\ViewModel\ToolBar;
use Npl\Brique\ViewModel\Inputs\InputModel;
use Npl\Brique\ViewModel\Inputs\ButtonModel;

class ToolBarFactory{
    public static function newToolBar(){
        return new ToolBarModel();
    }

    public static function newBlocBar($position="left"){
        return new BlocBarModel($position);
    }

    public static function newInput($nomComposant,$contenue,$id="",$name=""){
        return new Input($nomComposant,$contenue,$id,$name);
    }

    public static function barSave(){
        return self::newToolBar()
               ->addBlocBar(
                   self::newBlocBar()
                   ->addInput(new ButtonModel())
               );
    }

}