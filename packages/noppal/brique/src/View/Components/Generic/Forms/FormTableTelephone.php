<?php

namespace Npl\Brique\View\Components\Forms;

use Illuminate\View\Component;

class FormTableTelephone extends Component
{
    public $name,$indicatif,$numero,$labelText,$idTelephone;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$labelText,$idTelephone,$indicatif='',$numero='')
    {
        $this->indicatif=$indicatif;
        $this->name=$name;
        $this->labelText=$labelText;
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
        return view('npl::components.forms.form-table-telephone');
    }
}
