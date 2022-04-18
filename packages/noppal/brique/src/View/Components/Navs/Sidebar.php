<?php

namespace Npl\Brique\View\Components\Navs;

use Illuminate\View\Component;

class Sidebar extends Component
{
    public $model,$id,$active;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model,$id)
    {
        $this->model=$model;
        $this->id=$id;
        //dd(request()->session());

        if(request()->session()->has('toggle_sidebar') &&
                request()->session()->get('toggle_sidebar')=='on' )
            $this->active=true;
        else
            $this->active=false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.navs.sidebar');
    }
}
