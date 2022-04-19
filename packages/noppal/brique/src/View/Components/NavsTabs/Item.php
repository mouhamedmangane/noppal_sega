<?php

namespace Npl\Brique\View\Components\NavsTabs;

use Illuminate\View\Component;

class Item extends Component
{
    public $text,$id,$idPane,$active,$badge,$badgeType;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text,$idPane,$id="",$active=false,$badge="",$badgeType="")
    {
        $this->text = $text;
        $this->idPane = $idPane;
        $this->id = $id;
        $this->badge = $badge;
        $this->badgeType = $badgeType;
        $this->active =$active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.navs-tabs.item');
    }
}
