<?php

namespace Npl\Brique\Util\DataBases;

use Illuminate\Support\Facades\Auth;

class DoneByUser{

    public static function inject($model,$default=null){
        if(Auth::user()){
            $model->done_by_user=Auth::user()->id;
        }
        else{
            $model->done_by_user=$default;

        }
    }
}
