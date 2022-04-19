<?php

namespace Npl\Brique\View\Components\Bagde;

use Illuminate\View\Component;

class Simple extends Component
{
    public $name,$classStyle;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$classStyle)
    {
        $this->name = $name;
        $this->classStyle = $classStyle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.bagde.simple');
    }
}
