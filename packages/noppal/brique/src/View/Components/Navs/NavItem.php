<?php

namespace Npl\Brique\View\Components\Navs;

use Illuminate\View\Component;
use Npl\Brique\ViewModel\Navs\NavItemModel;

class NavItem extends Component
{   

    public $name,$url,$icon,$active;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$url,$icon="",$active=false)
    {
        $this->name = $name;
        $this->url = $url;
        $this->icon = $icon;
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.navs.nav-item');
    }
}
