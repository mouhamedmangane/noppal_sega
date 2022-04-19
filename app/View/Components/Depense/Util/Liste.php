<?php

namespace App\View\Components\Depense\Util;

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
            (object)['name'=>'N°','propertyName'=>'numero','classStyle'=>"text-left"],
            (object)['name'=>"Somme",'propertyName'=>'somme_f','classStyle'=>"text-right"],

            (object)['name'=>"Description",'propertyName'=>'description','classStyle'=>" "],

            (object)['name'=>"Type Dépense",'propertyName'=>'type_depense_f','classStyle'=>" "],
            (object)['name'=>"Crée le",'propertyName'=>'created_at_f','visible'=>true,'classStyle'=>" "],

            (object)['name'=>"Note",'propertyName'=>'note','classStyle'=>""],
            (object)['name'=>"Modifier le",'propertyName'=>'updated_at_f','visible'=>false,'classStyle'=>""],

        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.depense.util.liste');
    }
}
