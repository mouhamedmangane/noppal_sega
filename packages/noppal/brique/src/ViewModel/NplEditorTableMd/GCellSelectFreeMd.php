<?php

namespace Npl\Brique\ViewModel\NplEditorTableMd;
class GCellSelectFreeMd extends GCellSelectMd{



    public $nameDep;
    public $urlDep;

    public function __construct($name,$refName,$label,$nameDep,$urlDep){
        parent::__construct($name,$refName,$label);
        $this->classGCell="GCellSelectFree";
        $this->nameDep = $nameDep;
        $this->urlDep = $urlDep;
       
    }



}