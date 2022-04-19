<?php

namespace App\View\Components\Generic\Dashboard;

use Illuminate\View\Component;

class Cadre extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    //{{-- border, taille card icon title valeur --}}
    public $taille;
    public $couleur;
    public $icon;
    public $title;
    public $valeur;




    public function __construct($taille,$couleur,$icon,$title,$valeur)
    {
        //
        $this->taille=$taille;
        $this->couleur=$couleur;
        $this->icon=$icon;

        $this->title=$title;
        $this->valeur=$valeur;



    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.generic.dashboard.cadre');
    }
}
