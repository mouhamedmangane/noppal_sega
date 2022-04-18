<?php

namespace Npl\Brique\View\Components\NavsTabs;

use Illuminate\View\Component;

class Nav extends Component
{
    public $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id="")
    {
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.navs-tabs.nav');
    }
}
