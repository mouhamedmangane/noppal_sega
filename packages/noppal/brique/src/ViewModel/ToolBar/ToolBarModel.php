<?php

namespace Npl\Brique\ViewModel\ToolBar;


class ToolBarModel {
    public $listBlocBar;

    public function __construct(){
        $this->listBlocBar =[];
    }

    public function addBlocBar(BlocBarModel $blocbarModel){
        $this->listBlocBar[] = $blocbarModel;
        return $this;
    }
}