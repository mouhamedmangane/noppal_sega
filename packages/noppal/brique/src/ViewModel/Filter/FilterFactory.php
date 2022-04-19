<?php
namespace Npl\Brique\ViewModel\Filter;

use Npl\Brique\ViewModel\Filter\LigneFilterSelectMd;
use Npl\Brique\ViewModel\Filter\LigneFilterIntervalrMd;
use Npl\Brique\ViewModel\Filter\LigneFilterOneMd;
use Npl\Brique\ViewModel\Filter\FilterMd;

class FilterFactory {

    public static function filterMd($idSelect="",$list=[]){
        return new FilterMd($idSelect,$list);
    }
    public static function ligneIntervalMd($name,$label,$type,$min,$max,$value,$op='egal'){
        return new LigneFilterIntervalMd($name,$label,$type,$min,$max,$value,$op);

    }

    public static function ligneSelectMd($name,$data=[]){
        return new LigneFilterSelectMd($name,$data);
    }

    public static function ligneOneMd($name,$label,$type,$value,$op='egal'){
        return new LigneFilterOneMd($name,$label,$type,$value,$op);
    }
}
