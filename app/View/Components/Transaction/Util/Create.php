<?php

namespace App\View\Components\Transaction\Util;

use App\Models\TypeDepense;
use App\Models\TypeTransaction;
use Illuminate\View\Component;

class Create extends Component
{

    public $transaction;
    public $type_depenses;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->transaction=$model;
        $this->type_depenses=TypeDepense::all()->pluck('id','id');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.transaction.util.create');
    }
}
