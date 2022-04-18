<?php

namespace Npl\Brique\View\Components\ToolBar;

use Illuminate\View\Component;

class PrevButton extends Component
{
    public $id,$url;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$url)
    {
        $this->id=$id;
        $this->url=$url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.tool-bar.prev-button');
    }
}
