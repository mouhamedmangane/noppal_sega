<?php

namespace Npl\Brique\View\Components\Input;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $name,$value,$labelText;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$value="",$labelText="")
    {
        $this->name = $name;
        $this->value = $value;
        $this->labelText = $labelText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.input.checkbox');
    }
}
