<?php

namespace App\View\Components\Achat\Util;

use App\Models\Bois;
use Illuminate\View\Component;
use DataTables;

class AddTronc extends Component
{
    public $achat;
    public $bois;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->achat=$model;
        $this->bois=Bois::orderBy('name','desc')->get()->pluck("name",'id');
    }


    public function getTitle(){
        return [
            (object)  ['name'=>'Ref.','propertyName'=>'identifiant'],
            (object)  ['name'=>'Poids','propertyName'=>'poids'],
            (object)  ['name'=>'Bois  ','propertyName'=>'bois'],
            (object)  ['name'=>'date ','propertyName'=>'created_at_f'],
            (object)  ['name'=>'Action ','propertyName'=>'action'],
        ];

    }




    public function render()
    {
        return view('components.achat.util.add-tronc');
    }
}
