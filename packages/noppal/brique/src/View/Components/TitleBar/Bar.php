<?php

namespace Npl\Brique\View\Components\TitleBar;

use Illuminate\View\Component;

class Bar extends Component
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
        return view('npl::components.title-bar.bar');
    }
}
