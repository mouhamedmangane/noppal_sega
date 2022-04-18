<?php

namespace Npl\Brique\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'role_users_table', 'role', 'user_id');
    }

    public function role_objets(){
        return $this->hasMany('App\Models\RoleObjet','role_id','id');
    }


}
