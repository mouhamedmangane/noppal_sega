<?php

namespace App\View\Components\Depense\Util;

use Illuminate\View\Component;

class Voir extends Component
{

    public $depense;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->depense=$model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.depense.util.voir');
    }
}
