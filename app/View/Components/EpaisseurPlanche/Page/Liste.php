<?php

namespace App\View\Components\EpaisseurPlanche\Page;

use App\Models\EpaisseurBois;
use Illuminate\View\Component;

class Liste extends Component
{
    public $epaisseur;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->epaisseur=new EpaisseurBois();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.epaisseur-planche.page.liste');
    }
}
