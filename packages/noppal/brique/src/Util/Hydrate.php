<?php

namespace Npl\Brique\Util;

class Hydrate {

    public $props,$cilbe,$source;

    public function __construct($cible,$source,$props){
        $this->props=$props;
        $this->cible=$cible;
        $this->source=$source;
    }

    public function addProp($source,$cible){
        $this->props[$source]=$cible;
    }
    private function exist($element,$prop,$attrs=[]){
        if(isset($element->$prop) && !empty($element->$prop))
            return true;
        else
            return false;
    }

    public function verify($element,$prop,$chaine){
        $chs=explode('|',$chaine);
        foreach($chs as  $ch){
            $e_test=explode(':',$ch);
            $method=$e_test[0];
            $attrs=[];
            if(count($e_test)>1){
                $attrs=explode(',',$e_test[1]);
            }

            $test=$this->$method($element,$prop,$attrs);
            if(!$test){
                return false;
            }
        }
        return true;
    }

    public function make(){
        foreach($this->props as $key=>$prop){

            $p_cibles=explode('/',$key);
            $p_sources=explode('/',$prop);

            $p_cible=$p_cibles[0];
            $p_source=$p_sources[0];
            $control1=true;
            $control2=true;
            if(count($p_sources)>1){
                $control1=$this->verify($this->source,$p_source,$p_sources[1]);
            }
            if(count($p_cibles)>1){
                $control1=$this->verify($this->cible,$p_cible,$p_sources[1]);
            }

            if(is_int($key)){
                $this->cible->$prop = $this->source->$prop;
            }
            else{
                if($control1 && $control2){
                    $this->cible->$p_cible = $this->source->$p_source;
                }
            }


        }
    }

}
