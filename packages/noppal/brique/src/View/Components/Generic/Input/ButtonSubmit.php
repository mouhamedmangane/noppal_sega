<?php

namespace Npl\Brique\View\Components\Input;

use Illuminate\View\Component;

class ButtonSubmit extends Component
{
    public $idForm;
    public $id;
    public $idContentAlert;
    public $icon;
    public $text;

  


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($idForm,$id,$text,$icon="",$idContentAlert="")
    {
        $this->idForm =$idForm;
        $this->id = $id;
        $this->text = $text;
        $this->icon = $icon;
        $this->idContentAlert = $idContentAlert;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.input.button-submit');
    }
}
