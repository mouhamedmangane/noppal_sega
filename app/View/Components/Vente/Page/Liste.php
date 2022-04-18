<?php

namespace App\View\Components\Vente\Page;

use App\ModelHaut\VenteHaut;
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
                ->add(FilterFactory::ligneSelectMd('etat','Etat')
                      ->addLIgne(VenteHaut::COMMANDE,ucfirst(VenteHaut::COMMANDE))
                      ->addLIgne(VenteHaut::ACCOMPTE,ucfirst(VenteHaut::ACCOMPTE))
                      ->addLIgne(VenteHaut::COMPLETE,ucfirst(VenteHaut::COMPLETE))
                )
                ->add(FilterFactory::ligneOneMd('client','Client','text',''))
                ->add(FilterFactory::ligneIntervalMd('date_creation','Date Creation','date',0,0,0))
                ;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.vente.page.liste');
    }
}
