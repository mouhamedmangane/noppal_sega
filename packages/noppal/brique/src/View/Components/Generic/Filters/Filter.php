<?php

namespace Npl\Brique\View\Components\Filters;

use Illuminate\View\Component;
use Npl\Brique\ViewModel\Filter\FilterMd;

class Filter extends Component
{
    public $filter;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(FilterMd $filter)
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
        return view('npl::components.filters.filter');
    }
}
