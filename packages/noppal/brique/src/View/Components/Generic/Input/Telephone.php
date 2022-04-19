<?php

namespace Npl\Brique\View\Components\Input;

use Illuminate\View\Component;

class Telephone extends Component
{
    public $name,$indicatif,$numero,$idTelephone;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$idTelephone,$indicatif='',$numero='')
    {
        $this->name = $name;
        $this->indicatif=$indicatif;
        $this->numero=$numero;
        $this->idTelephone=$idTelephone;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.input.telephone');
    }
}
