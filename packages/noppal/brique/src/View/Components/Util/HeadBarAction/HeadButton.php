<?php

namespace Npl\Brique\View\Components\Util\headBarAction;

use Illuminate\View\Component;

class HeadButton extends Component
{
    public $idContent;
    public $icon;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($idContent="",$icon="")
    {
        $this->idContent = $idContent;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.util.head-bar-action.head-button');
    }
}
