<?php

namespace App\View\Components\Transaction\Page;

use Illuminate\View\Component;
use Npl\Brique\ViewModel\Filter\FilterFactory;

class Liste extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getFilter(){
        return  FilterFactory::filterMd('mySearch')
                ->add(FilterFactory::ligneIntervalMd('somme','somme','number',0,0,0))
                ->add(FilterFactory::ligneIntervalMd('date_creation','Date Creation','date',0,0,0))
                ;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.transaction.page.liste');
    }
}
