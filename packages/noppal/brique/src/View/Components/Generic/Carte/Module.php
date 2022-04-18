<?php

namespace Npl\Brique\View\Components\Carte;

use Illuminate\View\Component;

class Module extends Component
{
    public $name,$icon;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$icon)
    {
        $this->name=$name;
        $this->icon=$icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.carte.module');
    }
}
