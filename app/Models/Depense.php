<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    public function numero(){
        return "DS-".$this->id;
    }

    public function ligneAchatP(){
        return $this->hasOne("App\Models\LigneAchatP",'depense_id','id');
    }
}
