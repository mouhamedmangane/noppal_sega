<?php

namespace Npl\Brique\View\Components\Table;

use Illuminate\View\Component;

class KeyValueListItem extends Component
{
    public $key,$value;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($key,$value)
    {
        $this->key=$key;
        $this->value=$value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.table.key-value-list-item');
    }
}
