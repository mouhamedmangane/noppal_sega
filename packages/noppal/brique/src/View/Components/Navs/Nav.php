<?php

namespace Npl\Brique\View\Components\Navs;

use Illuminate\View\Component;

use Npl\Brique\ViewModel\Navs\NavModel;
use Npl\Brique\ViewModel\Navs\NavtestClasse;

class Nav extends Component
{


    public $navModel;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $navModel)
    {
        $this->navModel = $navModel;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.navs.nav');
    }
}
