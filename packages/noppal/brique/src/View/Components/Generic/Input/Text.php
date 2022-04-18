<?php

namespace Npl\Brique\View\Components\Input;

use Illuminate\View\Component;

class Text extends Component
{
    public $type,$name,$value;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$type="",$value="")
    {
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.input.text');
    }
}
