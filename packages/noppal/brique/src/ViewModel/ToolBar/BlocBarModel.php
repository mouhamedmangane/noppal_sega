<?php

namespace Npl\Brique\ViewModel\ToolBar;
use Npl\Brique\ViewModel\Inputs\InputModel;

class BlocBarModel {
    public $listInput;
    public $position;

    public function __construct($position="left"){
        $this->listInput = [];
        $this->position ="left";
    }

    public function addInput(InputModel $input){
        $this->listInput = $input;
        return $this;
    }

}