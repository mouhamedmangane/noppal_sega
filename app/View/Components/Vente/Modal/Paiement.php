<?php

namespace App\View\Components\Vente\Modal;

use Illuminate\View\Component;

class Paiement extends Component
{
    public $vente,$dataTableId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model,$dataTableId)
    {
        $this->vente=$model;
        $this->dataTableId = $dataTableId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.vente.modal.paiement');
    }
}
