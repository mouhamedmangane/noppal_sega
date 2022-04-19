<?php

namespace App\View\Components\Generic\Dashboard;

use Illuminate\View\Component;

class Cadre2 extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title;
    public $valeur;
    public $nombre;
    public $icon;
    public $couleur;
    public function __construct ($title,$valeur,$nombre,$icon,$couleur){

        //
        $this->valeur=$valeur;
        $this->nombre=$nombre;
        $this->icon=$icon;
        $this->couleur=$couleur;
        $this->title=$title;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.generic.dashboard.cadre2');
    }
}
