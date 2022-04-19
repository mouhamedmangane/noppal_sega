<?php

namespace Npl\Brique\View\Components\Forms;

use Illuminate\View\Component;

class FormTableText extends Component
{
    public $name,$type,$value,$labelText;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$labelText,$type="",$value="")
    {
        $this->name = $name;
        $this->value = $value;
        $this->labelText = $labelText;
        $this->type =$type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.forms.form-table-text');
    }
}
