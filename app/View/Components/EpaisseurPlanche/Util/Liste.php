<?php

namespace App\View\Components\EpaisseurPlanche\Util;

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
            (object)['name'=>'id','propertyName'=>'id_f','classStyle'=>"col-dt-2"],
            (object)['name'=>'nom','propertyName'=>'nom','classStyle'=>"col-dt-2"],
            (object)['name'=>'Modifier le','propertyName'=>'created_at_f','classStyle'=>"col-dt-1"],
            (object)['name'=>'Crée le','propertyName'=>'updated_at_f','classStyle'=>"col-dt-1"],
            (object)['name'=>'Dernier Utilisateur','propertyName'=>'utilisateur','classStyle'=>"","visible"=>false],
        ];
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.epaisseur-planche.util.liste');
    }
}
