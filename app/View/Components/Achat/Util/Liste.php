<?php

namespace App\View\Components\Achat\Util;

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

    public function getTitle(){
        return [
            (object)['name'=>'N°','propertyName'=>'numeroAchat','classStyle'=>""],
            (object)['name'=>'Etat','propertyName'=>'ouvert_f','classStyle'=>""],
            (object)['name'=>'Founisseur','propertyName'=>'fournisseur','classStyle'=>""],
            (object)['name'=>'Poids F(kg)','propertyName'=>'poids_f','classStyle'=>""],
            (object)['name'=>'Somme','propertyName'=>'somme_f','classStyle'=>""],
            (object)['name'=>'Chauffeur','propertyName'=>'chauffeur','classStyle'=>""],
            (object)['name'=>"Date creation",'propertyName'=>'date','classStyle'=>""],
        ];
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.achat.util.liste');
    }
}
