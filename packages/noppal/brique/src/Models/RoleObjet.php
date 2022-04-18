<?php

namespace Npl\Brique\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RoleObjet extends Model
{
    use HasFactory;

    public function objet(){
        return $this->belongsTo("Npl\Brique\Models\Objet");
    }

    public function role(){
        return $this->belongsTo("App\Models\Role");
    }
}
