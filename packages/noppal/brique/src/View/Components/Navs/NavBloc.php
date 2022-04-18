<?php

namespace Npl\Brique\View\Components\Navs;

use Illuminate\View\Component;
use Npl\Brique\ViewModel\Navs\NavTestClasse;

class NavBloc extends Component
{
    use NavTestClasse;

    public $name;
    public $navElementModels;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($navElementModels,$name ="")
    {   
        $this->name = $name;
        $this->navElementModels = $navElementModels;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.navs.nav-bloc');
    }
}