<?php

namespace Npl\Brique\View\Components\Input;

use Illuminate\View\Component;

class ShowAjaxModal extends Component
{
    public $url,$idModal;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url,$idModal)
    {
        $this->url= $url;
        $this->idModal=$idModal;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.input.show-ajax-modal');
    }
}
