<?php

namespace Npl\Brique\ViewModel\Navs;

trait NavTestClasse{
    public function isNavItemModel(NavElementModel $navElementModel){
        if($navElementModel instanceof NavItemModel){
            return true;
        }
        return false;
    }

    public function isNavGroupModel(NavElementModel $navElementModel){
        if($navElementModel instanceof NavGroupModel){
            return true;
        }
        return false;
    }

    public function isNavBlocModel(NavElementModel $navElementModel){
        if($navElementModel instanceof NavBlocModel){
            return true;
        }
        return false;
    }

}