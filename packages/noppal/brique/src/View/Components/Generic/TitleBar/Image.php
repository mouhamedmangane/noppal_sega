<?php

namespace Npl\Brique\View\Components\TitleBar;

use Illuminate\View\Component;

class Image extends Component
{
    public $src;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($src)
    {
        $this->src=$src;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.title-bar.image');
    }
}
