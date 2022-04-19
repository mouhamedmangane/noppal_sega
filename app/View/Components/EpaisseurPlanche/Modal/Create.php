<?php

namespace App\View\Components\EpaisseurPlanche\Modal;

use Illuminate\View\Component;

class Create extends Component
{
    public $epaisseur,$idDataTable;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model,$idDataTable)
    {
        $this->epaisseur=$model;
        $this->idDataTable=$idDataTable;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.epaisseur-planche.modal.create');
    }
}
