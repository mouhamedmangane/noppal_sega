<?php

namespace Npl\Brique\ViewModel\NplEditorTableMd;

class GCellSelectMd extends GCellMd{

    private const OP_UNIQUE='unique';
    //Default Select
    private const OP_DEFAULT_OPTION='defaultOption';
    private const DEFAULT_OPTION_TEXT='text';
    private const DEFAULT_OPTION_VALUE='value';
    private const DEFAULT_SELECT_TEXT='selectionner';

    //Default ValueProp and TextProp
    private const DEFAULT_VALUE_PROP='value';
    private const DEFAULT_TEXT_PROP='text';

    public $textProp;
    public $valueProp;

    public function __construct($name,$refName,$label){
        parent::__construct($name,$refName,$label);
        $this->classGCell="GCellSelect";
        $this->valueProp = self::DEFAULT_VALUE_PROP;
        $this->textProp = self::DEFAULT_TEXT_PROP;
        $selectText=self::DEFAULT_SELECT_TEXT.$name;
        $this->options[self::OP_DEFAULT_OPTION]=(object)[$this->textProp=>$selectText];
    }

    public function setProp($textProp,$valueProp){
        $this->textProp=$textProp;
        $this->valueProp=$valueProp;
        return $this;
    }
    public function unique($isunique){
        $this->options['unique'] = $isunique;
        return $this;
    }

    public function defaultOption($text,$value=''){
        $this->options['defaultOption']=(object)[self::DEFAULT_OPTION_VALUE=>$value,self::DEFAULT_OPTION_TEXT=>$text];
        return $this;
    }

    public function defaultOptionWithObject($object){
        $this->options['defaultOption']=$object;
        return $this;
    }

}