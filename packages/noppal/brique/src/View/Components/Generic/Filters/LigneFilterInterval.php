<?php

namespace Npl\Brique\View\Components\Filters;

use Illuminate\View\Component;
use Npl\Brique\ViewModel\Filter\LigneFilterIntervalMd;

class LigneFilterInterval extends Component
{
    public $ligne;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(LigneFilterIntervalMd $ligne)
    {
        $this->ligne =$ligne;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.filters.ligne-filter-interval');
    }
}
