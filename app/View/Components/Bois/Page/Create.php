<?php

namespace App\View\Components\Bois\Page;

use Illuminate\View\Component;

class Create extends Component
{
    public $bois;

    public $statusbois="Actif",
           $couleurbois="success";

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->bois=$model;
        if($model->archived==1){
            $this->statusbois="Désactivé";
            $this->couleurbois='danger';
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.bois.page.create');
    }
}
