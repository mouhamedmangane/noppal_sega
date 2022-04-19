<?php

namespace App\View\Components\Achat\Page;

use Illuminate\View\Component;

class Voir extends Component
{
    public $achat;
    public
    $restant_info="0",$couleur_restant_info="success",
    $total_prix_revient_info="0 ",
    $total_kl_info='0',
    $total_vente_info='0';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->achat=$model;
        if($model->id){
            $restant=$model->restant();
            $this->restant_info=number_format($restant,'0',',',' ');
            if($restant>0 && $restant<$model->somme){
                $this->couleur_restant_info="danger";
            }
            $this->total_prix_revient_info=number_format($model->prixRevient(),'0',',',' ');
            $this->total_vente_info=number_format($model->totalMontantVendu(),'0',',',' ');
            $this->total_kl_info=number_format($model->poidsVendu(),'0',',',' ')
                                 .' / '
                                 .number_format($model->poidsReel(),'0',',',' ');
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.achat.page.voir');
    }
}
