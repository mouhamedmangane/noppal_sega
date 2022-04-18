<?php

namespace App\View\Components\Depense\Page;

use Illuminate\View\Component;

class Create extends Component
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
        return view('components.depense.page.create');
    }
}
