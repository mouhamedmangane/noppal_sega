<?php

namespace App\Http\Controllers\ParamCompte;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Npl\Brique\Util\HydrateFacade;
use Npl\Brique\Util\ImageFactory;
use DB,Validator;

class EntrepriseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('droit:bois,r')->only('index','getData');
        $this->middleware('droit:bois,c')->only('store','create');
        $this->middleware('droit:bois,u')->only('update','archiverMany','desarchiverMany','archiver','desarchiver','destroy');

    }

    public function index(){
        return view("pages.param-compte.entreprise.update");
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nom'=>'max:100',
            'tel_1'=>'max:255',
            'tel_2'=>'max:255',
            'ninea'=>'max:50',
            'logo'=>'image'
        ]);
        if($validator->fails()){
            return \Npl\Brique\Http\ResponseAjax\Validation::validate($validator);
        }
        else{
            DB::beginTransaction();
            try {
                $entreprise=Entreprise::where('id',1)->first();
                HydrateFacade::make($entreprise,$request,[
                    'nom','tel_1','tel_2','ninea'
                ]);
                ImageFactory::store($request,$entreprise,'logo','images',$entreprise->id);
                //dd($entreprise);
                $entreprise->update();
                DB::commit();

                return [
                    'status'=>true,
                    'message'=>'Enregistrement effectué avec success',
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
