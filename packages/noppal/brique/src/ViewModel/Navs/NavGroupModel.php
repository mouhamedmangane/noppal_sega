<?php

namespace Npl\Brique\ViewModel\Navs;

use App\Util\Access;

Class NavGroupModel implements NavElementModel{


    public $name,$icon,$active;
    public $navElementModels;
    public $droit="true";

    public function __construct($name,$icon="",$navElementModels=[])
    {
        $this->name = $name;
        $this->icon = $icon;
        $this->navElementModels= $navElementModels;
    }

    public function getName(){
        return $this->name;
    }

    public function addNavElementModel(NavElementModel $navElementModel){
        $this->navElementModels[]=$navElementModel;
        return $this;
    }

    public function addNavItemModel($name,$url,$active=false){
        return $this->addNavElementModel(new NavItemModel($name,$url,"",$active));
    }

    public function addNavGroupModel(NavGroupModel $navGroupModel){
        $this->addNavElement($navGroupModel);
        return $this;
    }

    public function removeNavElementModel(NavElement $navElementModel){
        $index = array_search($navElementModels,$navElementModels);
        if($index)
            array_splice($navElementModels,$index,$index);
        else
            throw new \Excpetion("La suppresion ne marche pas car index no trouvé");

        return $this;
    }

    public function access($object,Array $droits){
        $this->droit=Access::canAccess($object,$droits);
        return $this;
    }
}
