<?php

namespace Npl\Brique\View\Components\DataTable;

use Illuminate\View\Component;

class ChildCell extends Component
{
    public $classStyle,//nom de la variable datatable dans le js
           $style,
           $slot;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($classStyle,$style,$slot)
    {
        $this->classStyle = $classStyle;
        $this->style = $style;
        $this->slot = $slot;
    
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render(){
        return view('npl::components.data-table.child-cell');
    }
}
