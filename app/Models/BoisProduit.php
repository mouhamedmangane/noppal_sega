<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoisProduit extends Model
{
    use HasFactory;

    public function bois(){
        return $this->belongsTo("App\Models\Bois");
    }
    /**
     * Get all of the lignes_ventes for the BoisProduit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ligne_ventes(): HasMany
    {
        return $this->hasMany('App\Models\LigneVente');
    }

    public function epaisseur(){
        return $this->belongsTo("App\Models\EpaisseurBois");
    }
}
