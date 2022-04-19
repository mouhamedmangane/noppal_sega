<?php

namespace App\View\Components\Generic\Dashboard;

use Illuminate\View\Component;

class Cadre3 extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $valeur;
    public function __construct($valeur)
    {
        $this->valeur=$valeur;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.generic.dashboard.cadre3');
    }
}
