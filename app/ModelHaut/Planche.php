<?php
namespace App\ModelHaut;

use App\Models\BoisProduit;
use DB;

class Planche {
    public const DISCRIMINANT='planche';


    public static function total_m3(){
        return BoisProduit::select(
                DB::raw( "sum(quantite * m3) as t_m3"))
            ->where('discriminant',self::DISCRIMINANT)
            ->where('archived',0)->first()->t_m3;
    }

    public static function query(){
        return BoisProduit::where('discriminant',self::DISCRIMINANT);
    }

    public static function newPlanche(){
        $boisProduit = new BoisProduit();
        $boisProduit->discriminant=self::DISCRIMINANT;
        return $boisProduit;
    }

    public static function get($id){
        return BoisProduit::where('id',$id)->first();
    }

    public static function isActive($id){
        return BoisProduit::where('id',$id)->where("archived",0)->exists();
    }

    public static function resemblance($m3,$longueur,$largueur,$epaisseur){
        return self::query()->where("m3",$m3)
                            ->where("longueur",$longueur)
                            ->where("largueur",$largueur)
                            ->where("epaisseur_bois_id",$epaisseur)
                            ->first();
    }
}
