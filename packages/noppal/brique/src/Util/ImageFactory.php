<?php
namespace Npl\Brique\Util;
use Illuminate\Http\Request;
use Auth;

class ImageFactory {

    public static function store(Request $request,$model,$attrRequest,$directory,$id,$attrDatabase=''){
        if($request->has($attrRequest)){
            $nameFile=$id.'.'.$request->$attrRequest->extension();
            $request->$attrRequest->move($directory,$nameFile);
            if(empty($attrDatabase)){
                $attrDatabase=$attrRequest;
            }
            $model->$attrDatabase=$nameFile;
        }

    }

    public static function url_image($path,$path_secour){
        if(file_exists(public_path($path)))
            return $path;
        return  $path_secour;

    }
    public static function profil_user($user){
        if(isset($user->photo)){
            $path='images/users/'.$user->photo;
            return self::url_image($path,'images/profig.jpg');
        }
        else{
            return '';
        }

    }

    public static function profil_current_user(){
        return self::profil_user(Auth::user());
    }
}
