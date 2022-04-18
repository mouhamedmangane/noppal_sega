<?php

namespace App\View\Components\Achat\Page;

use Illuminate\View\Component;
use DataTables;

class AddTronc extends Component
{

    public $achat;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->achat=$model;
    }




    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.achat.page.add-tronc');
    }
}
