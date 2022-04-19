<?php

namespace App\View\Components\Tronc\Util;

use App\Models\Bois;
use Illuminate\View\Component;

class Create extends Component
{
    public $tronc,$bois;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->tronc=$model;
        $this->bois=
            [0=>"Ancun Bois"]+
            Bois::where('archived',0)->get()->pluck('name','id')->toArray()
        ;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tronc.util.create');
    }
}
