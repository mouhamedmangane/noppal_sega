<?php

namespace Npl\Brique\View\Components\ToolBar;

use Illuminate\View\Component;

class BarSave extends Component
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
        return view('npl::components.tool-bar.bar-save');
    }
}
