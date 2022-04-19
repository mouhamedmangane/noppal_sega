<?php

namespace App\View\Components\Bois\Modal;

use Illuminate\View\Component;

class Create extends Component
{
    public $bois;
    public $titreModal;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->bois=$model;
        if($model->id){
            $this->titreModal="Modification Bois";
        }else{
            $this->titreModal='Nouveau Bois';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.bois.modal.create');
    }
}
