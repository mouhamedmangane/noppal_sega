<?php

namespace App\View\Components\TypeDepense\Page;

use Illuminate\View\Component;

class liste extends Component
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
        return view('components.type-depense.page.liste');
    }
}
