<?php

namespace App\View\Components\Transaction\Util;

use Illuminate\View\Component;

class Voir extends Component
{

    public $transaction;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->transaction=$model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.transaction.util.voir');
    }
}
