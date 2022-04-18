<?php

namespace Npl\Brique\ViewModel\BarreActions;

class Action{
 

    
    public $id,$url,$name,$type,$icon;

    public function __construct($id,$name,$url,$type,$icon="")
    {
        //
        $this->id=$id;
        $this->name=$name;
        $this->url=$url;
        $this->type=$type;
        $this->icon=$icon;
    }


}