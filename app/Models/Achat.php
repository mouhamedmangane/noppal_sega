<?php

namespace App\Models;

use App\ModelHaut\AchatHaut;
use App\ModelHaut\Tronc;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    use HasFactory;

    public function numero(){
        return 'AS-'.$this->id;
    }
    public function fournisseur(){
        return $this->belongsTo("App\Models\Contact",'fournisseur_id','id');
    }

    public function troncs(){
        return $this->hasMany('App\Models\BoisProduit');
    }

    public function chauffeur(){
        return $this->belongsTo("App\Models\Contact",'chauffeur_id','id');
    }

    public function nbrTronc(){
        return BoisProduit::where("achat_id",$this->id)->where('discriminant',Tronc::DISCRIMINANT)->count();
    }

    public function nbrPaiement(){
        return  Achat::join('ligne_achat_p_s','achats.id','ligne_achat_p_s.achat_id')
        ->leftJoin('depenses','ligne_achat_p_s.depense_id','depenses.id')
        ->where('ligne_achat_p_s.achat_id',$this->id)
        ->where('depenses.type_depense_id',AchatHaut::TYPE_DEPENSE_PAIE)
        ->count();
    }

    public function nbrFrais(){
        return  Achat::join('ligne_achat_p_s','achats.id','ligne_achat_p_s.achat_id')
        ->leftJoin('depenses','ligne_achat_p_s.depense_id','depenses.id')
        ->where('ligne_achat_p_s.achat_id',$this->id)
        ->where('depenses.type_depense_id',AchatHaut::TYPE_DEPENSE_FRAIS)
        ->count();
    }

    public function poidsReel(){
        return BoisProduit::where("achat_id",$this->id)->where('discriminant',Tronc::DISCRIMINANT)->sum('poids');
    }

    public function poidsVendu(){
        return LigneVente::join("bois_produits",'ligne_ventes.bois_produit_id','bois_produits.id')
                         ->where('bois_produits.achat_id',$this->id)
                         ->sum('bois_produits.poids');
    }

    public function totalMontantVendu(){
        return LigneVente::join("bois_produits",'ligne_ventes.bois_produit_id','bois_produits.id')
                         ->where('bois_produits.achat_id',$this->id)
                         ->sum('ligne_ventes.prix_total');
    }


    public function totalPaiement(){
        return Achat::join('ligne_achat_p_s','achats.id','ligne_achat_p_s.achat_id')
                    ->leftJoin('depenses','ligne_achat_p_s.depense_id','depenses.id')
                    ->where('ligne_achat_p_s.achat_id',$this->id)
                    ->where('depenses.type_depense_id',AchatHaut::TYPE_DEPENSE_PAIE)
                    ->sum('depenses.somme');
    }

    public function restant(){
        return $this->somme - $this->totalPaiement();
    }

    public function totalFrais(){
        return Achat::join('ligne_achat_p_s','achats.id','ligne_achat_p_s.achat_id')
                    ->leftJoin('depenses','ligne_achat_p_s.depense_id','depenses.id')
                    ->where('ligne_achat_p_s.achat_id',$this->id)
                    ->where('depenses.type_depense_id',AchatHaut::TYPE_DEPENSE_FRAIS)
                    ->sum('depenses.somme');
    }


    public function prixRevient(){
        return $this->totalPaiement()+$this->totalFrais();
    }

    //semie complete si la somme et le poids sont renseignés
    public function isSemiComplete(){
        return !($this->id>0 &&($this->poids<=0 || $this->somme<=0));
    }

    public function isComplete(){
        //dd($this->restant());
        return $this->somme>0 && $this->restant()==0;
    }
}
