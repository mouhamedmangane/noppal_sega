<?php

namespace Npl\Brique\ViewModel\Filter;
use Npl\Brique\ViewModel\Filter\LigneFilterMd;

class LigneFilterOneMd extends LigneFilterMd{
    private  const POSSIBLE_TYPES=['text','date','number'];
    public const POSSIBLE_OPS=['egal','like'];
    public $op,$value;

    public function __construct($name,$label,$type,$value,$op="egal"){
        parent::__construct($name,$label);
        if(in_array(strtolower($type),self::POSSIBLE_TYPES)){
            $this->type = strtolower($type);
        }
        else{
            throw new Exception("le type donne dans le ligneFilterOneMd n'est pas accepté .
            Seull 'text','date','number'sont acceptés ", 1);

        }
        if(in_array(strtolower($op),self::POSSIBLE_OPS)){
            $this->op = strtolower($op);
        }
        else{
            throw new Exception("les op donné dans le ligneFilterOneMd n'est pas accepté .
            Seull 'egal','interval','interval_number' sont acceptés ", 1);
        }
        $this->value=$value;
    }

    public function getData(){
        return [
            $op => $value
        ];
    }

    public function getComponentName(){
        return "npl::filters.ligne-filter-one";
    }
}
