<?php

namespace App\Http\Controllers\Reglement;

use App\Http\Controllers\Controller;
use App\ModelFabrique\LigneReglementFabrique;
use App\Models\LigneReglement;
use App\Models\Reglement;
use App\Models\Transaction;
use Illuminate\Http\Request;

use DataTables,Validator,DB;
use Npl\Brique\Http\ResponseAjax\DeleteRow;
use Npl\Brique\Http\ResponseAjax\Validation;
use Npl\Brique\Rules\PositiveRule;
use Npl\Brique\Util\DataBases\DoneByUser;

class PaiementReglementController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('droit:reglement_paiement,c')->only('store');
        $this->middleware('droit:reglement_paiement,d')->only('destroy');

    }

    public function destroy(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'id'=>['numeric','exists:App\Models\LigneReglement,id'],
        ]);

        if($validator->fails()){
            return response()->json(Validation::validate($validator));
        }
        else{
            $ligne=LigneReglement::where('id',$request->id)->first();
            $reglement=$ligne->reglement;
            $res=DeleteRow::one('transactions',$ligne->transaction->id);
            $res['somme']=$reglement->totalSomme();
            $res['last']=$reglement->total();
            $res['etat']=$reglement->etat;
            $res['status']=true;
            return response()->json($res);
        }
    }


    public function store(Request $request){
        if($request->has('paiement_id') && $request->paiement_id>0){
            $validationArray=[
                // 'reglement_id'=>"exists:reglements,id",
                'paiement_id'=>"exists:ligne_reglements,id",
                'somme'=>[new PositiveRule]
            ];
            $id=$request->paiement_id;
        }
        else{
            $validationArray= [
                'reglement_id'=>"exists:reglements,id",
                'somme'=>[new PositiveRule]
            ];
            $id=0;
        }
        $res=$this->savePaiement($request,$validationArray,$id);
        return response()->json($res);
    }

    public function savePaiement(Request $request,$validationArray,$id=0){
        $validator = Validator::make($request->all()+['id'=>$id],$validationArray);
        $validator->after(function($validator)use($request,$id){

        });
        if($validator->fails()){
            return Validation::validate($validator);
        }
        else{
            DB::beginTransaction();
            try {

                if($id){
                    $ligneReglement=LigneReglement::where('id',$id)->first();
                    $dataBaseMethod='save';
                }else{
                    $ligneReglement=LigneReglementFabrique::newPaiement();
                    $ligneReglement->reglement_id=$request->reglement_id;
                    $dataBaseMethod='save';
                }

                DoneByUser::inject($ligneReglement);
                $ligneReglement->$dataBaseMethod($request->somme);
                $reglement=Reglement::find($ligneReglement->reglement_id);

                DB::commit();
                return [
                    'status'=>true,
                    'message'=>'Enregistrement effectué avec success',
                    'id'=>$reglement->id,
                    'initial'=>number_format($reglement->initial,0,',',' ').' FCFA',
                    'total_paiement'=>number_format($reglement->totalSomme(),0,',',' '),
                    'total_achat'=>number_format($reglement->totalAchat(),0,',',' '),
                    'last'=>number_format($reglement->total(),0,',',' ').' FCFA',
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
