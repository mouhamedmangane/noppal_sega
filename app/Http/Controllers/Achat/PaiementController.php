<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;
use App\ModelHaut\ContactHaut;
use App\ModelHaut\AchatHaut;
use App\Models\LigneAchatPaie;
use App\Models\LigneAchat;
use App\Models\Achat;
use App\Models\Depense;
use App\Models\LigneAchatP;
use App\Util\Access;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            'id'=>['numeric','exists:ligne_achat_p_s,id'],
        ]);

        if($validator->fails()){
            return response()->json(Validation::validate($validator));
        }
        else{
            $ligneAchatP=LigneAchatP::find($request->id);
            $type_depense=AchatHaut::type_depense_client($ligneAchatP->depense->type_depense_id);
            $achat=LigneAchatP::where('id',$request->id)->first()->achat;
            $depense=$ligneAchatP->depense;
            DeleteRow::one('ligne_achat_p_s',$request->id);
            $res=DeleteRow::one('depenses',$depense->id);
            $res+=['id'=>$achat->id,
                    'type_depense'=>$type_depense,
                    'prix_revient'=>$achat->prixRevient(),
                    'restant'=>$achat->restant(),
                    'total_paiement'=>$achat->totalPaiement(),
                    'total_frais'=>$achat->totalFrais(),
                    'nbr_paie'=>$achat->nbrPaiement(),
                    'nbr_frais'=>$achat->nbrFrais(),
                    'etat'=>$achat->etat,];
            // ContactHaut::updateCompte($achat->fournisseur_id);

            return response()->json($res);

        }
    }


    public function store(Request $request){
        if($request->has('paiement_id') && $request->paiement_id>0){
            $validationArray=[
                'achat_id'=>"exists:achats,id",
                'paiement_id'=>"exists:ligne_achat_p_s,id",
                'somme'=>[new PositiveRule],
                'type_depense'=>["required",Rule::in(['paie','frais'])]
            ];
            $id=$request->paiement_id;
        }
        else{
            $validationArray= [
                'achat_id'=>"exists:achats,id",
                'somme'=>[new PositiveRule],
                'type_depense'=>["required",Rule::in(['paie','frais'])]

            ];
            $id=0;
        }
        $res=$this->saveLigneDepense($request,$validationArray,$id);
        return response()->json($res);
    }

    public function saveLigneDepense(Request $request,$validationArray,$id=0){
        $validator = Validator::make($request->all()+['id'=>$id],$validationArray);

        $validator->after(function($validator)use($request){
            if($request->type_depense=="paie"){
                $achat=Achat::find($request->achat_id);
                if($achat->restant()<$request->somme && $achat->somme>0){
                    $validator->errors()->add(
                        'somme','Somme en exces'
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
                    $LigneAchatP=LigneAchatP::where('id',$id)->first();
                    $dataBaseMethod='update';
                }else{
                    $LigneAchatP=new LigneAchatP();
                    $LigneAchatP->achat_id=$request->achat_id;
                    $dataBaseMethod='save';
                }
                $typeDepense=($request->type_depense=='paie')?
                                AchatHaut::TYPE_DEPENSE_PAIE:AchatHaut::TYPE_DEPENSE_FRAIS;
                $depense=$this->saveDepense($request,$LigneAchatP,$typeDepense);
                $LigneAchatP->depense_id=$depense->id;

                $achat=Achat::where('id',$LigneAchatP->achat_id)->first();
                DoneByUser::inject($LigneAchatP);

                $LigneAchatP->$dataBaseMethod();
                // ContactHaut::updateCompte($achat->contact_id);



                DB::commit();
                return [
                    'status'=>true,
                    'message'=>'Enregistrement effectué avec success',
                    'id'=>$achat->id,
                    'prix_revient'=>$achat->prixRevient(),
                    'restant'=>$achat->restant(),
                    'total_paiement'=>$achat->totalPaiement(),
                    'total_frais'=>$achat->totalFrais(),
                    'nbr_paie'=>$achat->nbrPaiement(),
                    'nbr_frais'=>$achat->nbrFrais(),
                    'etat'=>$achat->etat,
                    'type_depense'=>$request->type_depense,
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

    public function saveDepense($request,$LigneAchatP,$typeDepense){
        if($LigneAchatP->depense_id>0){
            $depense=$LigneAchatP->depense;
            $operation="update";
        }
        else{
            $depense=new Depense();
            $operation='save';
        }
        $depense->description="Pour l'achat AS-".$request->achat_id;
        $depense->somme=$request->somme;
        $depense->type_depense_id=$typeDepense;
        $depense->updatable=false;
        DoneByUser::inject($depense);
        $depense->$operation();
        return $depense;
    }

    public function data(Request $request,$type,$id){
        $validator = Validator::make(['id'=>$id],[
            'id'=>["exists:achats,id"],
        ]);


        if($validator->fails()){
            $LigneAchatP=[];
            $message="Les données ne sont pas valides";
            $status=false;
        }
        else{
            $type_reel=($type=='paie')?AchatHaut::TYPE_DEPENSE_PAIE:AchatHaut::TYPE_DEPENSE_FRAIS;
            $LigneAchatP=LigneAchatP::select('ligne_achat_p_s.*')
                         ->Leftjoin('depenses','depenses.id','ligne_achat_p_s.depense_id')
                         ->where('depenses.type_depense_id',$type_reel)
                         ->where('ligne_achat_p_s.achat_id',$id)
                         ->get();
            $status=true;
            $message="";
        }
        return  DataTables::of($LigneAchatP)
            ->addColumn('montant',function($LigneAchatPaie){
                return  number_format($LigneAchatPaie->depense->somme,'0',',',' ')
                .view('npl::components.bagde.badge')
                    ->with('text','FCFA')
                    ->with('class','badge-success');;
            })
            ->addColumn('date',function($LigneAchatPaies){
                return $LigneAchatPaies->created_at->format(" d/m/Y à H:i");
            })
            ->addColumn('actions',function($ligne){
                $text='';
                $type_depense=($ligne->depense->type_depense_id==AchatHaut::TYPE_DEPENSE_PAIE) ? 'paie' : 'frais';
                if(Access::canAccess('encaissement',['c'])){
                    $text='<button data-id="'.$ligne->id.'" data-somme="'.$ligne->depense->somme.'" data-typedepense="'.$type_depense.'" class="btn btn-warning btn-sm btn-edit-paiement">
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
