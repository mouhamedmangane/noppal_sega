<?php

namespace App\View\Components\Reglement\Page;

use Illuminate\View\Component;

class ListForFourniseur extends Component
{
    public $fournisseur,$lastreglement;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fournisseur,$lastreglement)
    {
        $this->fournisseur=$fournisseur;
        $this->lastreglement=$lastreglement;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.reglement.page.list-for-fourniseur');
    }
}
