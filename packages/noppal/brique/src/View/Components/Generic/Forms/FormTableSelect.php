<?php

namespace Npl\Brique\View\Components\Forms;

use Illuminate\View\Component;

class FormTableSelect extends Component
{
    public $name,$dt,$labelText,$value;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$dt,$labelText,$value="")
    {
        $this->name = $name;
        $this->dt = $dt;
        $this->labelText = $labelText;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.forms.form-table-select');
    }
}
