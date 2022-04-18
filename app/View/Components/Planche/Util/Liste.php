<?php

namespace App\View\Components\Planche\Util;

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

    public function getHeadTable(){
        return [
            (object)['name'=>'Volume','propertyName'=>'m3_f','classStyle'=>""],
            (object)['name'=>'Bois','propertyName'=>'bois','classStyle'=>""],
            (object)['name'=>'Quantite','propertyName'=>'quantite_f','classStyle'=>""],
            (object)['name'=>'Epaisseur','propertyName'=>'epaisseur_f','classStyle'=>""],
            (object)['name'=>'longueur','propertyName'=>'longueur_f','classStyle'=>""],
            (object)['name'=>'largueur','propertyName'=>'largueur_f','classStyle'=>""],
            (object)['name'=>"Utilisateur",'propertyName'=>'utilisateur','visible'=>false,'classStyle'=>""],
            (object)['name'=>"Derniere Modification",'propertyName'=>'updated_at_f','visible'=>false],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.planche.util.liste');
    }
}
