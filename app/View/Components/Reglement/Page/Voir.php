<?php

namespace App\View\Components\Reglement\Page;

use Illuminate\View\Component;

class Voir extends Component
{

    public $reglement,$total;

    public $totalColor="primary";
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($reglement)
    {
        $this->reglement=$reglement;
        $this->total=$reglement->total();
        if($this->total>0){
            $this->totalColor="success";
        }
        else{
            $this->totalColor='danger';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.reglement.page.voir');
    }
}
