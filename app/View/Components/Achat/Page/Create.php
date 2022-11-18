<?php

namespace App\View\Components\Achat\Page;

use Illuminate\View\Component;

class Create extends Component
{
    public $achat,$reglement;
    public
           $total_paiement_info="0 ",
           $total_frais_info='0',
           $total_kl_info='0';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model,$reglement)
    {
        $this->achat=$model;
        $this->reglement=$reglement;
        if($model->id){
            $this->total_paiement_info=$model->totalPaiement();
            $this->total_frais_info=$model->totalFrais();
            $this->total_kl_info=number_format($model->poidsReel(),'0',',',' ');
        }


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.achat.page.create');
    }
}
