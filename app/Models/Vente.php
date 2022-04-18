<?php

namespace App\Models;

use App\ModelHaut\Tronc;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the Vente
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public  function tronc_couper($date)
    {
       $lignes=[];
       foreach(LigneVente::where('vente_id',$this->id)->get() as $ligne){
           if($ligne->bois_produit->couper==null){
            $lignes[]=$ligne;
           }
           else{
               $date_couper=new DateTime($ligne->bois_produit->couper);
                $date_couper=$date_couper->format("Y-m-d");
                if( $date_couper==$date){
                        $lignes[]=$ligne;
                }
           }
        }

       return $lignes;


    }

    public function client()
    {
        return $this->belongsTo('App\Models\Contact','contact_id','id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function ligne_ventes()
    {
        return $this->hasMany('App\Models\LigneVente');
    }
    public function ligne_paiements()
    {
        return $this->hasMany('App\Models\LignePaiement');
    }

    public function payement_complet(){
        return $this->sumVente() - $this->sumPayement()==0;
    }
    public function numero(){
        return "VS-N°".$this->id;
    }
    public function sumPayement(){
        return $this->ligne_paiements->sum('somme');
    }
    public function sumVente(){
        return $this->ligne_ventes->sum('prix_total');
    }
    public function sumRestant(){
        return $this->sumVente() - $this->sumPayement();
    }

    public function sumKg(){
        return  LigneVente::join('bois_produits','ligne_ventes.bois_produit_id','bois_produits.id')
                    ->where('bois_produits.discriminant',Tronc::DISCRIMINANT)
                    ->where('ligne_ventes.vente_id',$this->id)
                    ->sum('bois_produits.poids');
    }

    public function countTronc(){
        return  LigneVente::join('bois_produits','ligne_ventes.bois_produit_id','bois_produits.id')
                    ->where('bois_produits.discriminant',Tronc::DISCRIMINANT)
                    ->where('ligne_ventes.vente_id',$this->id)
                    ->count();
    }

    public function getName(){
        if($this->contact_id>0){
            return $this->client->nom;
        }
        else{
            return $this->nom;
        }
    }


}
