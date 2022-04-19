<?php

namespace Npl\Brique\View\Components\ToolBar;

use Illuminate\View\Component;

class Button extends Component
{
    public $id,
           $text;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$text)
    {
        $this->id=$id;
        $this->text=$text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.tool-bar.button');
    }
}
