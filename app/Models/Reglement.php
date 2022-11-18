<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reglement extends Model
{
    use HasFactory;

    public function fournisseur(){
        return $this->belongsTo(Contact::class,'fournisseur_id','id');
    }

    public function ligneReglements(){
        return $this->hasMany(LigneReglement::class);
    }

    public function totalSomme(){
        return -LigneReglement::join('transactions','ligne_reglements.transaction_id','transactions.id')
                ->where('ligne_reglements.reglement_id',$this->id)
                ->where('ligne_reglements.type','like',LigneReglement::PAIEMENT_TYPE)
                ->sum('somme');
    }

    public function totalAchat(){
        return Achat::where('reglement_id',$this->id)
                    ->sum('somme');
    }

    public function total(){
        return $this->initial+$this->totalSomme() - $this->totalAchat();
    }


}
