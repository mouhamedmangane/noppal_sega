<?php

namespace Npl\Brique\View\Components\NavsTabs;

use Illuminate\View\Component;

class Pane extends Component
{
    public $id,$active;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$active=false)
    {
        $this->id = $id;
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.navs-tabs.pane');
    }
}
