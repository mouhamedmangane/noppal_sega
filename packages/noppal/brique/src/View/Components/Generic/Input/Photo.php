<?php

namespace Npl\Brique\View\Components\Input;

use Illuminate\View\Component;

class Photo extends Component
{
    public $id,$name,$url,$x,$y;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$name,$url="",$x="100",$y="100")
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.input.photo');
    }
}
