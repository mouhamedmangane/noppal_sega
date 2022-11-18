<?php

namespace App\View\Components\Reglement\Util;

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
    }

    public function getTitle(){

        return [

         (object)  ['name'=>'Nom','propertyName'=>'nom_f','classStyle'=>'valign-center'],
         (object)['name'=>'Compte','propertyName'=>'compte_f','classStyle'=>'valigne-center text-left'],
         (object)['name'=>'Action','propertyName'=>'action','classStyle'=>'valigne-center'],
         (object)['name'=>'Date ','propertyName'=>'date','classStyle'=>'valigne-center'],


        ];
     }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.reglement.util.liste');
    }
}
