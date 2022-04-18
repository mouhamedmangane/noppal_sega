<?php

namespace Npl\Brique\View\Components\Infos;

use Illuminate\View\Component;

class InfoList extends Component
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
        return view('npl::components.infos.info-list');
    }
}
