<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;



    public function role_objets(){
        return $this->hasMany('Npl\Brique\Models\RoleObjet','role_id','id');
    }
}
