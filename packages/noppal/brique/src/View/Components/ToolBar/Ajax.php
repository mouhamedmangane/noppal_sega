<?php

namespace Npl\Brique\View\Components\ToolBar;

use Illuminate\View\Component;

class Ajax extends Component
{
    public $id,$text,$url,$method,$dt;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$text,$url,$method,$dt=[])
    {
        $this->id=$id;
        $this->text=$text;
        $this->url = $url;
        $this->method=$method;
        $this->dt=(object)$dt;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.tool-bar.ajax');
    }
}
