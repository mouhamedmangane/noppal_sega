<?php

namespace App\View\Components\Reglement\Util;

use Illuminate\View\Component;

class ListForFourniseur extends Component
{

    public $fournisseur;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fournisseur)
    {
        $this->fournisseur=$fournisseur;
    }

    public function getTitle(){

        return [
         (object)  ['name'=>'Numero','propertyName'=>'nom_f','classStyle'=>''],
         (object)['name'=>'Etat','propertyName'=>'etat_f','classStyle'=>'text-center'],
         (object)['name'=>'S.Initial','propertyName'=>'initial_f','classStyle'=>'text-left'],
         (object)['name'=>'S.Réglé','propertyName'=>'last_f','classStyle'=>'text-left'],
         (object)['name'=>'Date ','propertyName'=>'date'],
        ];
     }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.reglement.util.list-for-fourniseur');
    }
}
