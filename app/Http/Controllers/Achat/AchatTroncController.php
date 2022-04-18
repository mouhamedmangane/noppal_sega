<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;
use App\ModelHaut\GenIdTronc;
use App\ModelHaut\Tronc;
use App\ModelHaut\VenteHaut;
use App\Models\Achat;
use App\Models\BoisProduit;
use App\Models\LigneVente;
use App\Models\Vente;
use Illuminate\Http\Request;
use DataTables,DB,Validator;
use Exception;
use Npl\Brique\Rules\PositiveRule;
use Npl\Brique\Util\DataBases\DoneByUser;
use Npl\Brique\Util\HydrateFacade;

class AchatTroncController extends Controller
{
    public function getData($id){
        $troncs=BoisProduit::where("achat_id",$id)->orderBy('created_at','desc')->get();
        $total_tronc=$troncs->count();
        $total_poids=$troncs->sum('poids');
        $data = DataTables::of($troncs)

            ->addColumn('bois',function($tronc){

                return  $tronc->bois->name;
            })
            ->addColumn('created_at_f',function($tronc){
                return ($tronc->created_at)?$tronc->created_at->format('d-m-Y H:i'):'non defini';
            })
            ->addColumn('action',function($tronc){
                $date_dif= time() - $tronc->created_at->format("U");

                $t=(object)["id"=>$tronc->id,"poids"=>$tronc->poids,"created_at"=>$tronc->created_at,"bois_id"=>$tronc->bois_id,"identifiant"=>$tronc->identifiant];
                $action=view('npl::components.input.button')
                        ->with('class',"btn-sm btn-warning update_tronc")
                        ->with('id',"tronc".$tronc->id)
                        ->with('data',json_encode($t))
                        ->with('icon',"edit")
                        ->with('text',"");
                if($date_dif<3600){
                    $action.=view('npl::components.input.button')
                    ->with('class',"btn-sm btn-danger delete_tronc ml-2")
                    ->with('id',"tronc".$tronc->id)
                    ->with('data',$tronc->id)
                    ->with('icon',"remove")
                    ->with('text',"");
                }
                return $action;

            })
            ->rawColumns(['bois','created_at_f',"action"])
            ->with('status',true)
            ->with('message','')
            ->with('total_kg',$total_tronc)
            ->with('total',$total_poids)
            ->toJson();

            return $data;
    }

    public function  index($id){
        $achat = Achat::findOrFail($id);
        return view("pages.achat.add-tronc",compact("achat"));
    }

    public function store(Request $request,$idAchat){
        $achat=Achat::findOrFail($idAchat);
        $validator=Validator::make($request->all(),[
            "poids"=>['required',new PositiveRule],
            "bois"=>['required','exists:bois,id'],

        ]);
        $validator->after(function($validator)use($request){

            if(!empty($request->identifiant)
                && Tronc::query()->where('archived',0)->where('identifiant',$request->identifiant)->where('id','<>',$id)->exists()){
                    $iden=$request->identifiant;
                    $validator->errors()->add(
                        'identifiant', "l' identifiant  $iden existe déja dans le stock !"
                    );
            }
        });
        if($validator->fails()){
            return   \Npl\Brique\Http\ResponseAjax\Validation::validate($validator);
        }else{
            DB::beginTransaction();
            try {
                $dataBaseMethod='save';
                $modify_vente=false;
                $tronc= Tronc::newTronc();
                $enleverTronc=false;
                if($request->id>0){
                    $tronc=Tronc::get($request->id);
                    if(trim($tronc->identifiant)!= trim($request->identifiant)){
                        GenIdTronc::remettre($tronc->identifiant);
                        $enleverTronc=true;
                    }
                    if($tronc->archived==1){
                        $modify_vente=true;
                    }
                    $dataBaseMethod="update";
                }
                else{
                    $enleverTronc=true;
                }


                HydrateFacade::make($tronc,$request,['poids','bois_id'=>'bois']);
                $tronc->achat_id=$idAchat;
                if($request->has('coef')){
                    $tronc->poids= $request->coef * $request->poids;
                }
                if($request->id==0 && empty($tronc->identifiant)){
                    $tronc->identifiant=GenIdTronc::newId();
                    $enleverTronc=true;
                    if(Tronc::query()->where('archived',0)
                     ->where('identifiant',$tronc->identifiant)->where('id','<>',$request->id)->exists()){
                         GenIdTronc::coherence();
                         throw new Exception();
                     }
                }
                GenIdTronc::coherence();

                DoneByUser::inject($tronc);
                $tronc->$dataBaseMethod();
                if($enleverTronc)
                    GenIdTronc::enlever($tronc->identifiant);


                // modifier Vente
                if($modify_vente){
                    $ligne=LigneVente::join('bois_produits','ligne_ventes.bois_produit_id','bois_produits.id')
                        ->where('bois_produits.id',$tronc->id)
                        ->first();
                    $vente=Vente::find($ligne->vente_id);
                    VenteHaut::actualiserVente($vente);
                }


                DB::commit();
                return [
                    "status"=>true,
                    "message"=>"Enregistrement effectuée avec succée",
                    "id"=> $tronc->id,
                    "identifiant"=>$tronc->identifiant.' - '.$tronc->poids.'Kg',
                    "method"=>$dataBaseMethod
                ];

            } catch (\Throwable $th) {
                throw $th;
                return [
                    "status"=>false,
                    "message"=>"Erreur non traite",
                    "id"=>$achat->id
                ];

            }
        }
    }
}
