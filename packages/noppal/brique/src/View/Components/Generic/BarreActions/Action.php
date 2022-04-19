<?php

namespace Npl\Brique\View\Components\BarreActions;

use Illuminate\View\Component;

class Action extends Component
{
    public $id,$url,$name,$type,$icon;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$name,$url,$type,$icon="")
    {
        //
        $this->id=$id;
        $this->name=$name;
        $this->url=$url;
        $this->type=$type;
        $this->icon=$icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.barre-actions.action');
    }
}
