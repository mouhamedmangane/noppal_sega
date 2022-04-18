<?php

namespace App\View\Components\Planche\Util;

use App\Models\Bois;
use App\Models\EpaisseurBois;
use Illuminate\View\Component;

use DB;

class Create extends Component
{
    public $planche,$bois,$epaisseurs;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    // 70 459 85 68
    public function __construct($model)
    {
        $this->planche=$model;
        $this->bois=array_merge(
            [0=>"Ancun Bois"],
            Bois::where('archived',0)->get()->pluck('name','id')->toArray()
        );
        $this->epaisseurs=[];
        EpaisseurBois::where('archived',0)->get()->each(function ($item, $key) {
            $id=(double)$item->id."";
            $this->epaisseurs[$id]=$item->nom.' / '.$id.' cm';
        });;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.planche.util.create');
    }
}
