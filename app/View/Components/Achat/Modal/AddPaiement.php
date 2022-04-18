<?php

namespace App\View\Components\Achat\Modal;

use Illuminate\View\Component;

class AddPaiement extends Component
{
    public $achat,$dataTableId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model,$dataTableId)
    {
        $this->achat=$model;
        $this->dataTableId=$dataTableId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.achat.modal.add-paiement');
    }
}
