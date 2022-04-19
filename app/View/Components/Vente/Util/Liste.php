<?php

namespace App\View\Components\Vente\Util;

use Illuminate\View\Component;

class Liste extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function getTitle(){

       return [

        (object)  ['name'=>'N° Vente','propertyName'=>'numeroVente','classStyle'=>'dt-col-3'],
        (object)['name'=>'Client','propertyName'=>'client','classStyle'=>'dt-col-4'],
        (object)['name'=>'Etat','propertyName'=>'etat'],
        (object)['name'=>'Montant Total','propertyName'=>'montant'],
        (object)['name'=>'Montant à payé','propertyName'=>'montantRestant'],
        (object)['name'=>'Date ','propertyName'=>'date'],
        (object)['name'=>'Heure','propertyName'=>'heure'],
       ];
    }

    public function render()
    {
        return view('components.vente.util.liste');
    }
}
