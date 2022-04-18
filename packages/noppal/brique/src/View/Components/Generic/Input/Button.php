<?php

namespace Npl\Brique\View\Components\Input;

use Illuminate\View\Component;

class Button extends Component
{
    public $id;
    public $name;
    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$id="",$class="")
    {
        $this->id = $id;
        $this->name = $name;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.input.button');
    }
}
