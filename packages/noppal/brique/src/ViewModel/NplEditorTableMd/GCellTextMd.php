<?php

namespace Npl\Brique\ViewModel\NplEditorTableMd;

class GCellTextMd extends GCellMd {

    private const OP_TYPE='type';
    private const OP_DEFAULT_VALUE='defaultValue';

    public function __construct($name,$refName,$label){
        parent::__construct($name,$refName,$label);
        $this->classGCell="GCellText";
    }

    public function type($type){
        $this->addOption(self::OP_TYPE,$type);
        return $this;
    }

    public function defaultValue($value){
        $this->addOption(self::OP_DEFAULT_VALUE,$value);
        return $this;
    }

}
