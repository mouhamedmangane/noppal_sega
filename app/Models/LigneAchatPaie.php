<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneAchatPaie extends Model
{
    use HasFactory;

    public function achat(){
        return $this->belongsTo("App\Models\Achat");
    }
}
