<?php

namespace App\View\Components\Bois\Util;

use Illuminate\View\Component;

class Create extends Component
{
    public $bois;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->bois=$model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.bois.util.create');
    }
}
