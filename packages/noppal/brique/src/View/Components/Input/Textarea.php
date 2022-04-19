<?php

namespace Npl\Brique\View\Components\Input;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $name,$value;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$value="")
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.input.textarea');
    }
}
