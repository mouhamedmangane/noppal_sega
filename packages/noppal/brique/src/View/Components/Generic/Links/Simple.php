<?php

namespace Npl\Brique\View\Components\link;

use Illuminate\View\Component;

class Simple extends Component
{
    public $url,$text,$class,$src;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url,$text,$class='',$src='')
    {
        $this->url=$url;
        $this->text=$text;
        $this->class=$class;
        $this->src=$src;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.link.simple');
    }
}
