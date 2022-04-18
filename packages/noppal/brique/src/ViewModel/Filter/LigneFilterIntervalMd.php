<?php

namespace Npl\Brique\ViewModel\Filter;
use Npl\Brique\ViewModel\Filter\LigneFilterMd;

class LigneFilterIntervalMd extends LigneFilterMd{

    public  const POSSIBLE_TYPES=['number','date','datetime-local'];
    public  const POSSIBLE_OPS=['egal','interval','interval_egal'];
    public $min,$max,$egal,$op;

    public function __construct($name,$label,$type,$min,$max,$egal,$op="egal"){
        parent::__construct($name,$label);
        if(in_array(strtolower($type),self::POSSIBLE_TYPES)){
            $this->type = strtolower($type);
        }
        else{
            throw new Exception("le type donne dans le ligneFilterOneMd n'est pas accepté .
            Seull 'date','number'sont acceptés ", 1);

        }
        if(in_array(strtolower($op),self::POSSIBLE_OPS)){
            $this->op = strtolower($op);
        }
        else{
            throw new Exception("les op donné dans le ligneFilterOneMd n'est pas accepté .
            Seull 'egal','interval','interval_number' sont acceptés ", 1);
        }
        $this->min =$min;
        $this->max = $max;
        $this->egal = $egal;
    }

    public function getData(){
        return   [
            'min' => $this->min,
            'max' => $this->$max,
            'egal' => $this->$egal,
        ];
    }

    public function getComponentName(){
        return 'npl::filters.ligne-filter-interval';
    }
}
