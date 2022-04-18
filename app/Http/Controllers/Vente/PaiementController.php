<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use App\ModelHaut\ContactHaut;
use App\ModelHaut\VenteHaut;
use App\Models\LignePaiement;
use App\Models\LigneVente;
use App\Models\Vente;
use App\Util\Access;
use Illuminate\Http\Request;
use Npl\Brique\Http\ResponseAjax\DeleteRow;
use Npl\Brique\Http\ResponseAjax\Validation;
use Npl\Brique\Rules\PositiveRule;
use Npl\Brique\Util\DataBases\DoneByUser;
use Validator,DB,DataTables;

class PaiementController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('droit:encaissement,r')->only('index','getData');
        $this->middleware('droit:encaissement,c')->only('store','create');
        $this->middleware('droit:encaissement,u')->only('update');
        $this->middleware('droit:encaissement,d')->only('destroy');

    }

    public function destroy(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'id'=>['numeric','exists:App\Models\LignePaiement,id'],
        ]);

        if($validator->fails()){
            return response()->json(Validation::validate($validator));
        }
        else{
            $vente=LignePaiement::where('id',$request->id)->first()->vente;
            $res=DeleteRow::one('ligne_paiements',$request->id);
            VenteHaut::updateEtatVente($vente);
            $res['montant_restant']=$vente->sumRestant();
            $res['etat']=$vente->etat;
            ContactHaut::updateCompte($vente->contact_id);

            return response()->json($res);

        }
    }


    public function store(Request $request){
        if($request->has('paiement_id') && $request->paiement_id>0){
            $validationArray=[
                'vente_id'=>"exists:ventes,id",
                'paiement_id'=>"exists:ligne_paiements,id",
                'somme'=>[new PositiveRule]
            ];
            $id=$request->paiement_id;
        }
        else{
            $validationArray= [
                'vente_id'=>"exists:ventes,id",
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
            $vente=Vente::where('id',$request->vente_id)->first();

            if($request->somme < round($vente->sumRestant())){
                if((!$vente->client) || empty($vente->client->ncni_photo_1) || empty($vente->client->ncni_photo_1) ){
                    $validator->errors()->add(
                    '   client', "Les photos de la carte du client no=e sont pas rensoignées"
                    );

                }
            }




        });
        if($validator->fails()){
            return Validation::validate($validator);
        }
        else{
            DB::beginTransaction();
            try {

                if($id){
                    $lignePaiement=LignePaiement::where('id',$id)->first();
                    $dataBaseMethod='update';
                }else{
                    $lignePaiement=new LignePaiement();
                    $lignePaiement->vente_id=$request->vente_id;
                    $dataBaseMethod='save';
                }

                $lignePaiement->somme=$request->somme;
                $vente=Vente::where('id',$lignePaiement->vente_id)->first();
                DoneByUser::inject($lignePaiement);

                $lignePaiement->$dataBaseMethod();
                VenteHaut::updateEtatVente($vente);
                ContactHaut::updateCompte($vente->contact_id);



                DB::commit();
                return [
                    'status'=>true,
                    'message'=>'Enregistrement effectué avec success',
                    'id'=>$vente->id,
                    'montant_restant'=>$vente->sumRestant(),
                    'etat'=>$vente->etat,
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


    public function data(Request $request,$id){
        $validator = Validator::make(['id'=>$id],[
            'id'=>["exists:ventes,id"],
        ]);


        if($validator->fails()){
            $lignePaiements=[];
            $message="Les données ne sont pas valides";
            $status=false;
        }
        else{
            $lignePaiements=LignePaiement::where('vente_id',$id)->get();
            $status=true;
            $message="";
        }
        return  DataTables::of($lignePaiements)
            ->addColumn('montant',function($lignePaiement){
                return  number_format($lignePaiement->somme,'0',',',' ')
                .view('npl::components.bagde.badge')
                    ->with('text','FCFA')
                    ->with('class','badge-success');;
            })
            ->addColumn('date',function($lignePaiements){
                return $lignePaiements->created_at->format(" d/m/Y à H:i");
            })
            ->addColumn('actions',function($ligne){
                $text='';
                if(Access::canAccess('encaissement',['c'])){
                    $text='<button data-id="'.$ligne->id.'" data-somme="'.$ligne->somme.'" class="btn btn-warning btn-sm btn-edit-paiement">
                    <i class="material-icons md-14">edit</i>
                </button>';
                }
                if(Access::canAccess('encaissement',['d'])){
                    $text.=' <button data-id="'.$ligne->id.'"  class="btn btn-danger btn-sm btn-delete-paiement">
                            <i class="material-icons md-14">remove</i>
                        </button>
                        ';
                }

                return $text;
            })
            ->rawColumns(['date','montant','actions'])
            ->with('status',$status)
            ->with('message',$message)
            ->toJson();

    }
}
//$("input[type='checkbox']").attr('checked','checked')
