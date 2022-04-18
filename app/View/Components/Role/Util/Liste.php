<?php

namespace App\View\Components\Role\Util;

use Illuminate\View\Component;

class Liste extends Component
{
    public $roles;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($roles)
    {
        $this->roles=$roles;
    }

    public function getHeadTable(){
        return [
            (object)['name'=>'Nom','propertyName'=>'nom_role','classStyle'=>""],
            (object)['name'=>"Utilisateur",'propertyName'=>'nbr_user','classStyle'=>""],
            (object)['name'=>"Description",'propertyName'=>'description','classStyle'=>""],
        ];
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.role.util.liste');
    }
}
