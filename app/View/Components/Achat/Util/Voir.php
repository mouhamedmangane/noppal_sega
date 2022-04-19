<?php

namespace App\View\Components\Achat\Util;

use Illuminate\View\Component;

class Voir extends Component
{
    public $achat;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->achat=$model;


    }

    public function getTitle(){
        return [
            (object)  ['name'=>'Ref.','propertyName'=>'identifiant'],
            (object)  ['name'=>'Poids','propertyName'=>'poids'],
            (object)  ['name'=>'Bois  ','propertyName'=>'bois'],
            (object)  ['name'=>'date ','propertyName'=>'created_at_f'],
        ];

    }

    public function titlePayement(){
        return [
            (object) ['name'=>'Date Paiement','propertyName'=>'date'],
            (object) ['name'=>'Montant Reçu','propertyName'=>'montant'],
            (object) ['name'=>'Actions','propertyName'=>'actions'],


        ];

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.achat.util.voir');
    }
}
