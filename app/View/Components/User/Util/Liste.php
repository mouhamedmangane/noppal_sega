<?php

namespace App\View\Components\User\Util;

use Illuminate\View\Component;

class Liste extends Component
{
    public $users;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($users)
    {
        $this->users=$users;
    }

    public function getHeadTable(){
        return [
            (object)['name'=>'Nom','propertyName'=>'nom','classStyle'=>""],
            (object)['name'=>'Role','propertyName'=>'role','classStyle'=>""],
            (object)['name'=>"Login",'propertyName'=>'email','classStyle'=>""],
            (object)['name'=>"Tél",'propertyName'=>'tel','classStyle'=>""],
            (object)['name'=>"Crée le",'propertyName'=>'created_at_f','classStyle'=>"","visible"=>false],
            (object)['name'=>"Modifier le",'propertyName'=>'updated_at_f','classStyle'=>""],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.user.util.liste');
    }
}
