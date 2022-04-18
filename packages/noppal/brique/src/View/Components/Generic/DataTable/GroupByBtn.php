<?php

namespace Npl\Brique\View\Components\DataTable;

use Illuminate\View\Component;

class GroupByBtn extends Component
{
    private const EMPTY_GROUP=[''=>'Ancun'];
    public $id,$label,$dt,$idDataTable,$defaultSelected;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$label,Array $dt,$idDataTable,$defaultSelected=false)
    {
        $this->id=$id;
        $this->label=$label;
        $this->dt=self::EMPTY_GROUP+$dt;
        $this->idDataTable=$idDataTable;
        $this->defaultSelected=$defaultSelected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.data-table.group-by-btn');
    }
}
