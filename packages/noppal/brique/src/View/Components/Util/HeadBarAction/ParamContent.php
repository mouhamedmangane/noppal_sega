<?php

namespace Npl\Brique\View\Components\Util\HeadBarAction;

use Illuminate\View\Component;

class ParamContent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.util.head-bar-action.param-content');
    }
}
