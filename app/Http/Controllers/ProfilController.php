<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Util\ImageFactory;
use Validator,Auth,DB;
use App\Util\HydrateFacade;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Npl\Brique\Http\ResponseAjax\Validation;
use Npl\Brique\Rules\CheckHash;
use Npl\Brique\Util\HydrateFacade as UtilHydrateFacade;
use Npl\Brique\Util\ImageFactory as UtilImageFactory;

class ProfilController extends Controller
{
    public function photoForm(){
        return view('pages.profil.photo-form');
    }

    public function savePhoto(Request $request){
        $validator = Validator::make($request->all(),
        [
            'photo'=>'image'
        ]);
        if($validator->fails()){
            return Validation::validate($validator);
        }
        else{
            DB::beginTransaction();
            try {
                $user=Auth::user();
                UtilImageFactory::store($request,$user,'photo','images/users',$user->id);
                $user->update();
                DB::commit();
                return [
                    'status'=>true,
                    'message'=>'Enregistrement effectué avec success',
                    'id'=>$user->id
                ];
            } catch (\Throwable $th) {
                DB::rollback();

                return [
                    'status'=>false,
                    'message'=>__('messages.erreur_inconnu').' '.__('messages.operation_encore'),
                    'srr'=>dd($th)
                ];
            }
        }

    }

    public function profilForm(){
        $user=Auth::user();
        return view('pages.profil.profil-form',compact('user'));
    }

    public function profilSave(Request $request){

        $user=Auth::user();
        $validator = Validator::make($request->all(),
        [
            "login"=>["required","max:100",Rule::unique('users', 'email')->ignore($user->id),],
            "old_pwd"=>['bail',"required",new CheckHash ($user->password) ],
            "pwd"=>"confirmed|max:100",
        ]);
        if($validator->fails()){
            return Validation::validate($validator);
        }
        else{
            DB::beginTransaction();
            try {

                UtilHydrateFacade::make($user,$request,['email'=>'login','password'=>'pwd/exist']);
                if($request->filled('pwd')) {
                        $user->password=Hash::make($request->pwd);
                }
                $user->update();
                DB::commit();
                return [
                    'status'=>true,
                    'message'=>'Enregistrement effectué avec success',
                    'id'=>$user->id
                ];
            } catch (\Throwable $th) {
                DB::rollback();

                return [
                    'status'=>false,
                    'message'=>__('messages.erreur_inconnu').' '.__('messages.operation_encore'),
                    'srr'=>dd($th)
                ];
            }
        }

    }
}
