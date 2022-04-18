<?php

namespace Npl\Brique\View\Components\Bagde;

use Illuminate\View\Component;

class Simple extends Component
{
    public $text,$class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text,$class)
    {
        $this->text=$text;
        $this->class=$class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.badge.simple');
    }
}
