<?php

namespace App\View\Components\Reglement\Modal;

use Illuminate\View\Component;

class Paiement extends Component
{

    public $model,$dataTableId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model,$dataTableId)
    {
        $this->model=$model;
        $this->dataTableId=$dataTableId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.reglement.modal.paiement');
    }
}
