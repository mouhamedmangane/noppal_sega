<?php

namespace App\View\Components\Achat\Util;

use App\Models\Contact;
use Illuminate\View\Component;

class Create extends Component
{
    public $achat,$reglement;

    public $fournisseur;

    public $chauffeur;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model,$reglement)
    {
        $this->achat = $model;
        $this->reglement=$reglement;
    }

    public function getFournisseur(){
        return  Contact::where("is_fournisseur",1)->get()->map(function($item,$key){
            $item->new_name=$item->nameAndPhone();
            return $item;
        })->pluck('new_name','id')->prepend("Selectionner un fournisseur",0);
    }

    public function getChauffeur(){
        return  Contact::where("fonction",'like',"%chauffeur%")->get()->map(function($item,$key){
            $item->new_name=$item->nameAndPhone();
            return $item;
        })->pluck('new_name','id')->prepend("Selectionner un Chauffeur",0);;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.achat.util.create');
    }
}
