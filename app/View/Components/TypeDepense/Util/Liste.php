<?php

namespace App\View\Components\TypeDepense\Util;

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
            (object)['name'=>'Nom','propertyName'=>'nom','classStyle'=>"dt-col-3"],
            (object)['name'=>'Seuil','propertyName'=>'seuil_f','classStyle'=>"dt-col-3 text-center"],
            (object)['name'=>"Crée le",'propertyName'=>'created_at_f','classStyle'=>""],
            (object)['name'=>"Modifier le",'propertyName'=>'updated_at_f','classStyle'=>""],
        ];
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.type-depense.util.liste');
    }
}
