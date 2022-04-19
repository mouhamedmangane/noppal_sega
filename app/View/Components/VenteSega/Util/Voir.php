<?php

namespace App\View\Components\VenteSega\Util;

use Illuminate\View\Component;

class Voir extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.vente-sega.util.voir');
    }
}
