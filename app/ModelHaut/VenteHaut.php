<?php

namespace App\ModelHaut;

use App\Models\BoisProduit;
use App\Models\ContactPrix;
use App\Models\LignePaiement;
use App\Models\LigneVente;
use App\Models\TroncId;
use App\ModelsException\QuantiteInsiffussante;
use Exception;
use Npl\Brique\Util\DataBases\DoneByUser;

class VenteHaut {
    public const ACCOMPTE="accompte";
    public const COMMANDE="commande";
    public const COMPLETE="complete";
    public const IMCOMPLETE="incomplete";
    public const PAYE_NON_LIVRE="payé non livré";

    public static function createLigneVentes($vente,$request){

        for ($i=0; $i < count($request->produits); $i++) {
            $bois_produit_id=$request->produits[$i];
            $quantite=$request->quantite[$i];
            self::createLigneVente($bois_produit_id,$vente,$quantite,$vente->contact_id);
        }
    }

    public static function updateLigneVentes($vente,$request){
        // dd($request->all());
        $tous_lignes=$vente->ligne_ventes()->pluck('quantite','id')->toArray();
        $saved_lignes=[];
        for ($i=0; $i <count($request->produits); $i++) {
            $bois_produit_id=$request->produits[$i];
            $quantite=$request->quantite[$i];
            $ligne=self::updateLigneVente($bois_produit_id,$vente,$quantite);
            $saved_lignes[$ligne->id]=$ligne->quantite;
        }
        // dd($tous_lignes);
        if(count($tous_lignes)>0){
            $reste_lignes= array_diff_key($tous_lignes,$saved_lignes);
            foreach ($reste_lignes as $key => $value) {
                $ligneVente=LigneVente::where('id',$key)->first();
                self::deleteLigneVente($ligneVente);
            }
        }
    }
    public static function getPrix($vente,$ligneVente){

    }
    public static function updateStockProduit($operation,$produit,$quantite=0){
        if($produit->discriminant==Tronc::DISCRIMINANT){
            $produit->archived=($operation=="entrer") ? 0 : 1;
        }
        else{
            $produit->quantite+= ($operation=="entrer") ? ($quantite) : (-$quantite);
            if($produit->quantite<0){
                throw new QuantiteInsiffussante(" quantite incorrect ou insuffisante pour le produit .".$produit->m3.$produit->bois->nom);
            }
        }
        $produit->update();
    }

    public static function deleteLigneVente($ligneVente){
        $produit=$ligneVente->bois_produit;
        self::updateStockProduit("entrer",$produit,$ligneVente->quantite);
        $ligneVente->delete();
        if($produit->discriminant == Tronc::DISCRIMINANT){
            $tronc_id=TroncId::where('id','like',$produit->identifiant);
            $tronc_id->occuper=1;
            $tronc_id->update(['occuper'=>1]);
        }
    }

    public static function createLigneVente($bois_produit_id,$vente,$quantite,$contact_id,$user_id=null,$is_tv=0){
        $ligneVente = new LigneVente();
        $ligneVente->bois_produit_id=$bois_produit_id;
        $ligneVente->vente_id=$vente->id;
        $ligneVente->is_tv=$is_tv;
        $bois_produit= BoisProduit::where('id',$bois_produit_id)->first();
        self::mettre_prix_quantite($ligneVente,$bois_produit,$quantite,$contact_id);

        DoneByUser::inject($ligneVente,$user_id);

        $ligneVente->save();
        self::updateStockProduit("sortie",$bois_produit,$ligneVente->quantite);
        return $ligneVente;
    }

    public static function updateLigneVente($bois_produit_id, $vente,$quantite){
        $ligneVente=LigneVente::where('vente_id',$vente->id)
                              ->where('bois_produit_id',$bois_produit_id)->first();
        if($ligneVente && $ligneVente->id){
            $bois_produit= BoisProduit::where('id',$bois_produit_id)->first();
            self::updateStockProduit('sortie',$bois_produit,$quantite-$ligneVente->quantite);
            $ligneVente->quantite=$quantite;
            self::mettre_prix_quantite($ligneVente,$bois_produit,$quantite,$vente->contact_id);
            DoneByUser::inject($ligneVente);
            $ligneVente->update();
            return $ligneVente;
        }
        else{
            return self::createLigneVente($bois_produit_id,$vente,$quantite,$vente->contact_id);
        }
    }

    public static function mettre_prix_quantite($ligneVente,$bois_produit,$quantite,$contact_id=0){
        $prix_vente=0;
        if($contact_id){
            $prix_vente=ContactPrix::where('contact_id',$contact_id)->where('bois_id',$bois_produit->bois->id)->first();
            if($prix_vente)
                $prix_vente=$prix_vente->prix_vente;
            else
                $prix_vente=0;
        }
        if($bois_produit->discriminant==Tronc::DISCRIMINANT){
            $ligneVente->prix_total=(($prix_vente>0)?$prix_vente:$bois_produit->bois->prix_tronc)*$bois_produit->poids;
            $ligneVente->quantite=1;
            $ligneVente->prix_unitaire=($prix_vente>0)?$prix_vente:$bois_produit->bois->prix_tronc;
        }
        elseif($bois_produit->discriminant==Planche::DISCRIMINANT){
            if($quantite<=0)
                throw new Exception("Quantite doit etre superieur a 0");
            $ligneVente->quantite=$quantite;
            $ligneVente->prix_unitaire=$bois_produit->bois->prix_planche*$quantite;
            $ligneVente->prix_total=$bois_produit->bois->prix_planche*$quantite*$bois_produit->m3;

        }
        else{
            throw new Exception("id BoisProduit n'exsist pas");
        }
    }

    public static function totalVente($vente){
        return LigneVente::where('vente_id',$vente->id)->sum('prix_total');
    }

    public static function totalPaiement($vente){
        return LignePaiement::where('vente_id',$vente->id)->sum('somme');
    }

    public static function updateEtatVente($vente){
        $totalVente=round(self::totalVente($vente),0);
        $totalPaiement=round(self::totalPaiement($vente));

        if($totalPaiement>0 || $totalVente>0 ){
            if($totalPaiement==$totalVente){
                $vente->etat=self::COMPLETE;
            }
            else if($totalPaiement>$totalVente){
                $vente->etat=self::PAYE_NON_LIVRE;
            }
            else{
                $vente->etat= self::ACCOMPTE;
            }
        }
        else if($vente->etat!= self::ACCOMPTE){
            $vente->etat=self::COMMANDE;
        }
        $vente->update();
    }

    public function getPrixUnitaire($ligne){
        if($ligne->bois_produit->disctiminant == Tronc::DISCRIMINANT){
            return $ligne->prix_total / $ligne->bois_produit->poids;
        }
        else if($ligne->bois_produit->discriminant == Planche::DISCRIMINANT){
            return $ligne->prix_total / $ligne->bois_produit->m3;
        }
        else{
            throw new Exception("bois produit inconnue ");
        }
    }

    public static function recalculer($vente){
        foreach ($vente->ligne_ventes as $key => $ligne) {
            if($ligne->prix_unitaire <=0 && $ligne->bois_produit->discriminant==Tronc::DISCRIMINANT)
                throw new Exception('Inmpossible de modifier car prix unitaire est null');
            if($ligne->bois_produit->discriminant==Tronc::DISCRIMINANT)
                $ligne->prix_total=$ligne->prix_unitaire* $ligne->bois_produit->poids;
            else if($ligne->bois_produit->discriminant == Planche::DISCRIMINANT)
                $ligne->prix_total=$ligne->prix_unitaire * $ligne->bois_produit->m3;
            else
                throw new Exception('Bois produit inconnue');
            $ligne->update();
        }
    }
    public static function actualiserVente($vente){
        self::recalculer($vente);
        self::updateEtatVente($vente);
    }

    public static function libererJeton($vente){
        $ligneVentes=$vente->ligne_ventes;
        foreach($ligneVentes as $ligne){
            $produit=$ligne->bois_produit;
            if($produit->discriminant == Tronc::DISCRIMINANT){
                $count=BoisProduit::where('identifiant','like',$produit->identifiant)
                              ->where('id','<>',$produit->id)
                              ->where('archived',0)
                              ->count();
                if($count<=0){
                    $tronc_id=TroncId::where('id','like',$produit->identifiant);
                    $tronc_id->occuper=0;
                    $tronc_id->update(['occuper'=>0]);
                }
            }

        }
    }





}
