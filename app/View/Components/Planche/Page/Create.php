<?php

namespace App\View\Components\Planche\Page;

use Illuminate\View\Component;

class Create extends Component
{
    public $planche;

    public $statusInfo="actif",
           $couleurInfo="success";
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->planche=$model;
        if($model->archived==1){
            $this->statusInfo="Vendu";
            $this->couleurInfo="danger";
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.planche.page.create');
    }
}
