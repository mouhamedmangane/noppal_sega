<?php

namespace App\View\Components\Depense\Util;

use App\Models\TypeDepense;
use Illuminate\View\Component;

class Create extends Component
{

    public $depense;
    public $type_depenses;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->depense=$model;
        $this->type_depenses=TypeDepense::all()->pluck('id','id');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.depense.util.create');
    }
}
