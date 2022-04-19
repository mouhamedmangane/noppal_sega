<?php

namespace Npl\Brique\View\Components\Infos;

use Illuminate\View\Component;

class InfoItem extends Component
{
    public $title,$value,$link;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($value,$title="",$link="")
    {
        $this->title = $title;
        $this->value = $value;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.infos.info-item');
    }
}
