<?php

namespace Npl\Brique\Util;
use DB;

class NplFilter {



    public static function select($query,$request,$attribute,$clauses){
        if($request->has($attribute)){
            $filter=$request->$attribute;
            if($filter['op']){
                foreach ($filter['op'] as $key => $value) {
                    $clause=$clauses[$value];
                    $query->where($clause[0],$clause[1],$clause[2]);
                }
            }
        }
    }

    public static function one($query,$request,$attribute,$propertyDB,$typeValue,$op="whereRaw"){
        if($request->has($attribute)){
            $filter=$request->$attribute;
            if(isset($filter['valeur']) && !empty($filter['valeur'].'')){
                if($typeValue=='text'){
                    $query->$op($propertyDB,'like', '%'.$filter['valeur']."%" );
                }
                else{
                    $query->$op("CAST($propertyDB AS CHAR) like '%".$filter['valeur']."%'" );
                }
            }

        }
    }

    public static function interval($query,$request,$attribute,$propertyDB,$typeValue='',$propertyDBMax=''){
        if($request->has($attribute)){
            $filter=$request->$attribute;
            $tab=['min'=>'>=','max'=>'<='];
            $tabPropertys=['min'=> $propertyDB,'max'=>(empty($propertyDBMax))? $propertyDB:$propertyDBMax];
            if($filter["op_name"]=='interval'){
                $tab=['min'=>'>','max'=>'<'];
            }
            foreach ($tab as $key => $value) {
                if(isset($filter[$key]) && !empty($filter[$key].'') ){
                    if(!empty($filter[$key])){
                        if($typeValue=='date'){
                            $query->whereDate($tabPropertys[$key],$value,$filter[$key]);
                        }elseif($typeValue=='datetime'){
                            $query->where($tabPropertys[$key],$value,$filter[$key]);
                        }
                        else{
                            $query->where($tabPropertys[$key],$value,$filter[$key]);
                        }
                    }

                }
            }




        }
    }

}
