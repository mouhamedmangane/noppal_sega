<?php
namespace App\Service;
use App\Models\Contact;
use App\Models\Reglement;



class ReglementService{
    public static function generateReglement(){
        $fournisseurs=Contact::where('is_fournisseur','>',0)->get();
        $i=0;
        foreach($fournisseurs as $fournisseur){
            if(!Reglement::where('fournisseur_id',$fournisseur->id)->where('etat',0)->exists()){
                $reglement=new Reglement;
                $reglement->fournisseur_id= $fournisseur->id;
                $lastReglement=self::lastReglement($fournisseur->id);
                if($lastReglement)
                    $reglement->initial= $lastReglement;
                $reglement->save();
              }
            $i++;
        }
        return $i;
    }

    public static function newReglement($fournisseur_id){
        if(!Reglement::where('fournisseur_id',$fournisseur_id)->where('etat',0)->exists()){
            $reglement=new Reglement;
            $reglement->fournisseur_id= $fournisseur_id;
            $lastReglement=self::lastReglement($fournisseur_id);
            if($lastReglement){
                $reglement->initial= $lastReglement->total();
            }
             $reglement->save();
             return $reglement;
          }
          return null;
    }

    public static function lastReglement($fournisseur_id){
        return Reglement::where('fournisseur_id',$fournisseur_id)
                         ->orderBy('created_at','desc')
                         ->limit(1)
                         ->first();
    }
}
