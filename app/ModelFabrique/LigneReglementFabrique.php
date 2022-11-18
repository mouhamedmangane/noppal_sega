<?php
namespace App\ModelFabrique;

use App\Models\LigneReglement;

class LigneReglementFabrique{

    private static function newLigne($type){
        $ligne=new LigneReglement;
        $ligne->type=$type;
        return $ligne;
    }

    public static function newPaiement(){
        return self::newLigne(LigneReglement::PAIEMENT_TYPE);
    }
}
