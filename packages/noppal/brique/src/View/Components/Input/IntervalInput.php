<?php

namespace Npl\Brique\View\Components\Input;

use Illuminate\View\Component;

class IntervalInput extends Component
{
    public $radioData=['fixe'=>'Fixe','interval'=>'Interval'];
    public $name,$type,$minValue,$maxValue;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$type,$minValue=0,$maxValue=0)
    {
        //
        if(!array_key_exists($type, $this->radioData)){
            throw new Exception("Le type du IntervalInput avec le name $name doit etre egale a 'fixe' ou 'interval'", 1);
        }
        $this->type=$type;
        $this->name = $name;
        $this->minValue = $minValue;
        $this->maxValue = $maxValue;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.input.interval-input');
    }
}
