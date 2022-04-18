<?php

namespace App\View\Components\Tronc\Page;

use Illuminate\View\Component;
use Npl\Brique\ViewModel\Filter\FilterFactory;
use App\Models\Bois;
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
        $bois=Bois::all();
        $ligneSelectMd=FilterFactory::ligneSelectMd('bois','Bois');
        foreach ($bois as $key => $b) {
            $ligneSelectMd->addLIgne($b->id,$b->name);
        }
        return  FilterFactory::filterMd('mySearch')
                ->add(FilterFactory::ligneIntervalMd('kg','Kg','number',0,0,0))
                ->add(FilterFactory::ligneIntervalMd('date_creation','Date Creation','datetime-local',0,0,0))
                ->add($ligneSelectMd);
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tronc.page.liste');
    }
}
