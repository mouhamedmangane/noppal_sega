<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\ContactPrix;
use Illuminate\Http\Request;
use Npl\Brique\Http\ResponseAjax\Validation;
use Validator;

class PrixController extends Controller
{
    public function getContactPrix($id){
        $validator=Validator::make(['id'=>$id],[
            'id'=>"exists:contacts,id"
        ]);
        if($validator->fails()){
            return Validation::validate($validator);
        }
        else{
        $prix=ContactPrix::where('contact_id',$id)->get();

            return response()->json([
                "status"=>true,
                "data"=>$prix

            ]);
        }

    }
}
