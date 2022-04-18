<?php

namespace App\View\Components\Tronc\Util;

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
            (object)['name'=>'Identifiant','propertyName'=>'identifiant_f','classStyle'=>""],
            (object)['name'=>'Bois','propertyName'=>'bois','classStyle'=>""],
            (object)['name'=>'Poids','propertyName'=>'poids_f','classStyle'=>""],
            (object)['name'=>'longueur','propertyName'=>'longueur_f','classStyle'=>""],
            (object)['name'=>'Diametre','propertyName'=>'diametre_f','classStyle'=>""],
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
        return view('components.tronc.util.liste');
    }
}
