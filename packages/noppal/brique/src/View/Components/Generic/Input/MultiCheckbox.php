<?php

namespace Npl\Brique\View\Components\Input;

use Illuminate\View\Component;

class MultiCheckbox extends Component
{
    public $name,$value,$dt;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$dt,$value="")
    {
        $this->name = $name;
        $this->value = $value;
        $this->dt = $dt;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.input.multi-checkbox');
    }
}
