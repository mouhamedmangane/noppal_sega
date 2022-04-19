<?php

namespace Npl\Brique\View\Components\Filters;

use Illuminate\View\Component;

class SearchFilter extends Component
{
    public $id,$name,$dataTableId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$name,$dataTableId="")
    {
        $this->id = $id;
        $this->name = $name;
        $this->dataTableId =$dataTableId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.filters.search-filter');
    }
}
