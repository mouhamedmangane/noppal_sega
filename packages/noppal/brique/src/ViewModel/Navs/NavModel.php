<?php

namespace Npl\Brique\ViewModel\Navs;

class NavModel  {

    public $navBlocModels;


    public function __construct($navBlocModels=[]){
        $this->navBlocModels = $navBlocModels;
    }

     function addNavBlocModel (NavBlocModel $navBlocModel){
        $this->navBlocModels[] = $navBlocModel;
        return $this;
    }

    public function removeNavBlocModel(NavBlocModel $navBlocModel){
        $index = array_search($navBloc,$navBlocModels);
        if($index)
            array_splice($navBlocModels,$index,$index);
        else
            throw new \Excpetion("La suppresion ne marche pas car index no trouvé");

        return $this;
    }

    public function activer(){
        $tab=[];
        $i=0;
        foreach($this->navBlocModels as $navElement){
            $test = $this->searchActive($navElement,$tab);
        }
        //dd($this);
        return $this;
    }

    public function searchActive($navElement,$tab){
        if($navElement instanceof NavItemModel){
            if(request()->is($navElement->url.'*')){
                $navElement->active=true;
                return true;
            }
            else{
                return false;
            }
        }
        elseif($navElement instanceof NavBlocModel || $navElement instanceof NavGroupModel){
            foreach($navElement->navElementModels as $navElementchild){
                $test = $this->searchActive($navElementchild,$tab);
                if($test){
                    $navElement->active=true;
                }


            }
        }


    }




}
