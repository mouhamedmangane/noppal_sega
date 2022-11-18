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

        (object)  ['name'=>'N° Vente','propertyName'=>'numeroVente','classStyle'=>'d'],
        (object)['name'=>'Client','propertyName'=>'client','classStyle'=>''],
        (object)['name'=>'Etat','propertyName'=>'etat','classStyle'=>'valign-center'],
        (object)['name'=>'Montant Total','propertyName'=>'montant','classStyle'=>'valign-center'],
        (object)['name'=>'Montant à payé','propertyName'=>'montantRestant','classStyle'=>'valign-center'],
        (object)['name'=>'Date ','propertyName'=>'date','classStyle'=>'valign-center'],
        (object)['name'=>'Heure','propertyName'=>'heure','classStyle'=>'valign-center'],
       ];
    }

    public function render()
    {
        return view('components.vente.util.liste');
    }
}
