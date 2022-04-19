<?php

namespace App\View\Components\Bois\Page;

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

    }

    public function getFilter(){
        return  FilterFactory::filterMd('mySearch')
                ->add(FilterFactory::ligneSelectMd('type_contact','Type Contact')
                      ->addLIgne("client",'Client')
                      ->addLigne('fournisseur','Fournisseur')
                )
                ->add(FilterFactory::ligneOneMd('tel','Téléphone','number',''))
                ->add(FilterFactory::ligneOneMd('email','Email','text',''))
                ->add(FilterFactory::ligneOneMd('fonction','fonction','text',''))
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
        return view('components.bois.page.liste');
    }
}
