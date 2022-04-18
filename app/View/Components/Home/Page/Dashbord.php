<?php

namespace App\View\Components\Home\Page;

use Illuminate\View\Component;
use Npl\Brique\ViewModel\Filter\FilterFactory;
class Dashbord extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $donnees,$date;
    public $date_prec;
    public $date_suivant;
    public function __construct($donnees,$date=null)
    {
        //
        $this->donnees=$donnees;
        if($date==null){
            $this->date=now()->format('d-m-Y');

        }
        else{
            $this->date=$date;
        }
        $this->date_prec=date('Y-m-d', strtotime("$this->date -1 day"));
        $this->date_suivant=date('Y-m-d', strtotime("$this->date +1 day"));

      //  dd($this->donnees);

    }

    public function getFilter(){
        return  FilterFactory::filterMd('mySearch')

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
        return view('components.home.page.dashbord');
    }
}
