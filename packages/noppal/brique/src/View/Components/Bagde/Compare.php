<?php

namespace Npl\Brique\View\Components\Bagde;

use Illuminate\View\Component;

class Compare extends Component
{
    public $text1,$text2,$separateur,$className;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text1,$text2,$separateur,$className="bagde-success")
    {
        $this->text1=$text1;
        $this->text2=$text2;
        $this->separateur=$separateur;
        $this->className=$className;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.bagde.compare');
    }
}
