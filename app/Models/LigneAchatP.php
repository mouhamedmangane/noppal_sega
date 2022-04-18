<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneAchatP extends Model
{
    use HasFactory;

    public function depense(){
        return $this->belongsTo('App\Models\Depense');
    }

    public function achat(){
        return $this->belongsTo('App\Models\Achat');
    }
}
