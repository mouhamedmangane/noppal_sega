<?php

namespace App\View\Components\Bois\Util;

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
            (object)['name'=>'Nom','propertyName'=>'nom','classStyle'=>""],
            (object)['name'=>'P.Tronc(/kg)','propertyName'=>'prix_tronc_f','classStyle'=>""],
            (object)['name'=>'P.planche(/m3)','propertyName'=>'prix_planche_f','classStyle'=>""],
            (object)['name'=>'Troncs','propertyName'=>'total_tronc','classStyle'=>""],
            (object)['name'=>'Nbr Troncs','propertyName'=>'count_tronc','classStyle'=>""],
            (object)['name'=>'Planches','propertyName'=>'total_planche','classStyle'=>""],
            (object)['name'=>'R.Vente','propertyName'=>'ratio_vente','classStyle'=>""],
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
        return view('components.bois.util.liste');
    }
}
