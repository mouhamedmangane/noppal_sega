<?php

namespace App\View\Components\Tronc\Page;

use Illuminate\View\Component;

class Create extends Component
{
    public $tronc;

    public $statusInfo="actif",
           $couleurInfo="success";
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->tronc=$model;
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
        return view('components.tronc.page.create');
    }
}
