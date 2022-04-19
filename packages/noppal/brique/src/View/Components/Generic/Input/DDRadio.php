<?php

namespace Npl\Brique\View\Components\Input;

use Illuminate\View\Component;

class DDRadio extends Component
{
    public $id,$name,$label,$dt;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$name,$label,$dt)
    {
        $this->id=$id;
        $this->name=$name;
        $this->label=$label;
        $this->dt=$dt;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.input.d-d-radio');
    }
}
