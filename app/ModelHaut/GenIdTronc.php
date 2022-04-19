<?php

namespace App\ModelHaut;

use App\Models\TroncId;

class GenIdTronc{
    public static function coherence(){
        $troncs=Tronc::query()->where('archived',0)->get();
        foreach ($troncs as $key => $value) {
            $troncId=TroncId::where('id',$value->identifiant)->first();
            if($troncId->id){
                $troncId->occuper=1;
                $troncId->update();
            }
        }
    }
    public static function newId(){
        $row= TroncId::where('occuper',0)
                      ->orderBy('updated_at','asc')
                      ->first();

         return $row->id;
    }
    public static function enlever($id){
        $troncId=TroncId::where('id',$id)->first();
        if($troncId->id){
            $troncId->occuper=1;
            $troncId->update();
        }
    }
    public static function remettre($id){
        $troncId=TroncId::where('id',$id)->first();
        if($troncId->id){
            $troncId->occuper=0;
            $troncId->update();
        }
    }
}
