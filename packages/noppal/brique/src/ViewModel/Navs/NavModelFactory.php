<?php

namespace Npl\Brique\ViewModel\Navs;

class NavModelFactory{
    static function navModel(){
        return new NavModel();
    }

    static function navItemModel($name,$url="",$icon="",$active=false){
        return new NavItemModel($name,$url,$icon,$active);
    }

    static function navGroupModel($name,$icon=""){
        return new NavGroupModel($name,$icon);
    }
    static function navBlocModel(){
        return new NavBlocModel();
    }


}