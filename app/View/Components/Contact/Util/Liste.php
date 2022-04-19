<?php

namespace App\View\Components\Contact\Util;

use Illuminate\View\Component;

class Liste extends Component
{

    public $liste;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($liste)
    {
        $this->liste=$liste;
    }

    public function getHeadTable(){
        return [
            (object)['name'=>'Nom','propertyName'=>'nom','classStyle'=>""],
            (object)['name'=>"Fontions",'propertyName'=>'fonctions','classStyle'=>" "],
            (object)['name'=>"Compte",'propertyName'=>'compte_f','classStyle'=>""],
            (object)['name'=>"Téléphones",'propertyName'=>'tel','classStyle'=>""],
            (object)['name'=>"Email",'propertyName'=>'email','classStyle'=>""],
            (object)['name'=>"Crée le",'propertyName'=>'created_at_f','visible'=>false,'classStyle'=>""],
            (object)['name'=>"Modifier le",'propertyName'=>'updated_at_f','visible'=>false,'classStyle'=>""],
            (object)['name'=>"type",'propertyName'=>'type','visible'=>false,'classStyle'=>""],

        ];
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.contact.util.liste');
    }
}
