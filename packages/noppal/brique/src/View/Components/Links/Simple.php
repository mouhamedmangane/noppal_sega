<?php

namespace Npl\Brique\View\Components\link;

use Illuminate\View\Component;

class Simple extends Component
{
    public $url,$text,$class,$src,$icon;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url,$text,$class='',$src='',$icon='')
    {
        $this->url=$url;
        $this->text=$text;
        $this->class=$class;
        $this->src=$src;
        $this->icon=$icon;
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
