<?php

namespace Npl\Brique\View\Components\Forms;

use Illuminate\View\Component;

class FormTableInterval extends Component
{
    public $name,$labelText,$minValue,$maxValue,$type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$labelText,$type,$minValue=0,$maxValue=0)
    {
        $this->name =$name;
        $this->labelText = $labelText;
        $this->minValue =$minValue;
        $this->maxValue =$maxValue;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.forms.form-table-interval');
    }
}
