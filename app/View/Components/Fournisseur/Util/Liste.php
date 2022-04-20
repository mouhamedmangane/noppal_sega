<?php

namespace App\View\Components\Fournisseur\Util;

use Illuminate\View\Component;

class Liste extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void 
     */

    public function getTitle(){

       //'fournisseur','nombre_achat','somme_restante','somme_total','poids_total','last_date'

        
        return [
            (object)['name'=>'Founisseur','propertyName'=>'fournisseur','classStyle'=>""],
            (object)['name'=>'Nb Achat en_cours','propertyName'=>'nombre_achat','classStyle'=>""],//nbre de achats completes/nb_incomplete
            (object)['name'=>'Somme Restante','propertyName'=>'somme_restante','classStyle'=>""],
            (object)['name'=>'Somme Totale','propertyName'=>'somme_total','classStyle'=>""],
            (object)['name'=>'Poids F(kg)','propertyName'=>'poids_total','classStyle'=>""],
            (object)['name'=>"Date dernier achat",'propertyName'=>'last_date','classStyle'=>""],
        ];
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.fournisseur.util.liste');
    }
}
