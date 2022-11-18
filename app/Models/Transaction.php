<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    public function numero(){
        return 'TR-'.$this->id;
    }
    /**
     * Get all of the ligne_paiements for the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function ligne_paiement()
    {
        return $this->hasOne(LignePaiement::class);
    }

    public function getUrl(){
        switch ($this->type) {
            case 'VS':
                return 'vente/'.$this->correspondant;
                break;
            case 'AS':
                return 'reglement/'.$this->correspondant;
                break;
            default:
                return 'transaction/'.$this->id;
                break;
        }
    }
    public function ligneReglement(){
        return $this->hasOne(LigneReglement::class);
    }

}

