<?php

namespace App\View\Components\Entreprise\Util;

use Illuminate\View\Component;

class Update extends Component
{
    public $entreprise;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->entreprise=$model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.entreprise.util.update');
    }
}
