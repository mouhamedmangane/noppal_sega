<?php

namespace App\Util;

use App\Models\User;
use Auth;

class Access {

    public const ADMIN_ROLE_NAME= "Administration";

    public static function canAccess($object,$droit_names){
        if(Auth::user()->role->nom==self::ADMIN_ROLE_NAME){

                return true;
        }
        foreach(Auth::user()->role->role_objets as $rob){

            if($rob->objet->nom==$object){
                foreach ($droit_names as $key => $dn) {
                    if($rob->$dn && $rob->$dn==1){
                        return true;
                    }
                }

            }
        }
        return false;
    }

    public static function canAccessRaw( $tab){
        return self::canAccess($tab[0],$tab[1]);
    }
}
