<?php

namespace Npl\Brique\ViewModel\NplEditorTableMd;

class GCellFactory {
    static function text($name,$refName,$label){
        return new GCellTextMd($name,$refName,$label);
    }
    static function select($name,$refName,$label){
        return new GCellSelectMd($name,$refName,$label);
    }
    static function selectFree($name,$refName,$label,$nameDep,$urlDep){
        return new GCellSelectFreeMd($name,$refName,$label,$nameDep,$urlDep);
    }
}
