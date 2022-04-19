<?php

namespace App\ModelHaut;

use App\Models\BoisProduit;
use App\Models\LigneVente;
use Illuminate\Support\Str;

class Tronc {
    public const DISCRIMINANT='tronc';

    public static function query(){
        return BoisProduit::where('discriminant',self::DISCRIMINANT);
    }
    public static function newTronc(){
        $boisProduit = new BoisProduit();
        $boisProduit->discriminant=self::DISCRIMINANT;
        return $boisProduit;
    }

    public static function isFree($identifiant){
       return (bool) BoisProduit::where('archived',0)
                    ->where('identifiant','like',Str::of($identifiant)->trim())
                    ->count();
    }

    public static function estCouper($id){
        $bp=BoisProduit::find($id);
        if($bp->couper != null)
            return true;
        return false;
    }

    public static function free($identifiant){
        return BoisProduit::where('archived',0)
                     ->where('identifiant','like',"%".Str::of($identifiant)->trim())->get();
     }

    public static function getFree($identifiant){
        return BoisProduit::where('archived',0)
                     ->where('identifiant','like',Str::of($identifiant)->trim())->first();
    }

    public static function get($id){
        return BoisProduit::where('id',$id)->first();
    }

    public static function isActive($id){
        return BoisProduit::where('id',$id)->where("archived",0)->exists();
    }

    public static function updatePrixUnitaire(){
        $lignes=LigneVente::all();
        foreach ($lignes as $key => $ligne) {
            if($ligne->bois_produit->discriminant == Tronc::DISCRIMINANT){
                if($ligne->bois_produit->poids<=0){
                    dd($ligne->id);
                }
                $ligne->prix_unitaire=$ligne->prix_total / $ligne->bois_produit->poids;

            }
            else if($ligne->bois_produit->discriminant == Planche::DISCRIMINANT){

                $ligne->prix_unitaire=$ligne->prix_total / $ligne->bois_produit->m3;

            }
            else{
                dd($ligne->bois_produit);
            }
            $ligne->update();
        }

    }
}
