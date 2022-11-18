<?php

namespace App\View\Components\Reglement\Util;

use Illuminate\View\Component;

class Voir extends Component
{

    public $reglement;
     /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($reglement)
    {
        $this->reglement=$reglement;
    }


    public function titleTable(){
        return [
            (object) ['name'=>'Date Paiement','propertyName'=>'date','classStyle'=>'dt-col-6'],
            (object) ['name'=>'Description','propertyName'=>'description','classStyle'=>''],
            (object) ['name'=>'Montant','propertyName'=>'montant','classStyle'=>'text-right'],

            (object) ['name'=>'Action','propertyName'=>'action','classStyle'=>''],
        ];

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.reglement.util.voir');
    }
}
