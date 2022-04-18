<?php

namespace Npl\Brique\View\Components\ToolBar;

use Illuminate\View\Component;
use Npl\Brique\ViewModel\Filter\FilterMd;

class Barlist extends Component
{   
    public $url,
           $filter;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(FilterMd $filter=null)
    {
        $this->filter=$filter;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.tool-bar.barlist');
    }
}
