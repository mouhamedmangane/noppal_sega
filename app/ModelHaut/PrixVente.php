<?php

namespace App\Util;

use App\Models\LigneVente;

class PrixVente{
    public static function recupererPrix($vente){
        return  LigneVente::select('bois.name as nom ,ligne_ventes.prix_unitaire as prix')
                    ->join('bois_produits','ligne_ventes.bois_produit_id','bois_produits.id')
                    ->join('bois','bois_produits.bois_id.','bois.id')
                    ->where('ligne_vente.id',$vente->id)
                    ->grouby('nom','prix')
                    ->get();

    }


}
