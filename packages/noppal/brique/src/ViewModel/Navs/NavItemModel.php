<?php

namespace Npl\Brique\ViewModel\Navs;

use App\Util\Access;

Class NavItemModel implements NavElementModel{
    public $name,$url,$icon,$active;
    public $droit=true;
    public function __construct($name,$url="",$icon="",$active=false)
    {
        $this->name = $name;
        $this->url = $url;
        $this->icon = $icon;
        $this->active = $active;
    }

    public function getName(){
        return $this->name;
    }

    public function access($object,Array $droits){
        $this->droit=Access::canAccess($object,$droits);
    }

}
