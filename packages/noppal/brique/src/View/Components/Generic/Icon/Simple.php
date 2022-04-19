<?php

namespace Npl\Brique\View\Components\Icon;

use Illuminate\View\Component;

class Simple extends Component
{
    public $name,$taille;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$taille)
    {
        $this->name=$name;
        $this->taille=$taille;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.icon.simple');
    }
}
