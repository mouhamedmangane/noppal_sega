<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ModelHaut\Tronc;
use App\Models\BoisProduit;
use App\Models\LignePaiement;
use App\Models\LigneVente;
use App\Models\Vente;
use App\Service\VenteService as ServiceVenteService;
use Illuminate\Http\Request;
use Npl\Brique\Http\ResponseAjax\Validation as ResponseAjaxValidation;
use PhpParser\Node\Stmt\TryCatch;
use Validator,DB,DataTables;
class TroncControllerApi extends Controller{

    public function troncACouper($search=""){
        $troncs=BoisProduit::where('discriminant',Tronc::DISCRIMINANT)
                            ->whereDate('created_at','>','2021-11-15')
                            ->whereNull('couper')
                            ->where(function($query) use($search){
                                $query->where('identifiant','like',"$search%");
                                $query->orWhereRaw(" cast(poids as varchar(10)) like '$search%' ");
                            })
                            ->get();
        return [
            'status'=>true,
            "data"=>$troncs
        ];

    }

    public function couper(Request $request){
        $validation=Validator::make($request->all(),[
            'identifiant'=>['exists:bois_produits,id'],
            "contact_id"=>['exists:contacts,id']
        ]);
        $validation->after(function($validator)use($request){
            if(Tronc::estCouper($request->identifiant)){
                $validator->errors()->add('identifiant',"le tronc est deja couper $request->identifiant");
            }
        });
        if($validation->fails()){
            return ResponseAjaxValidation::validate($validation);
        }
        else{
            DB::beginTransaction();
            try {
                $tronc= Tronc::get($request->identifiant);
                ServiceVenteService::newTroncCouper($request->contact_id,$tronc);
                DB::commit();
                return [
                    "status"=>true,
                    "message"=>"Enregistrement effectuée avec succée",
                    "id"=> $tronc->id
                ];
            } catch (\Throwable $th) {
                DB::rollback();

                return [
                    'status'=>false,
                    'message'=>$th->getMessage(),
                    'srr'=>$th
                ];
            }

        }
    }

    public function couper_simple(Request $request){
        $validation=Validator::make($request->all(),[
            'identifiant'=>['exists:bois_produits,id','exists:ligne_ventes,bois_produit_id'],
        ]);

        if($validation->fails()){
            return ResponseAjaxValidation::validate($validation);
        }
        else{
            DB::beginTransaction();
            try {
                $tronc= Tronc::get($request->identifiant);
                $tronc->couper=now();
                $tronc->update();
                DB::commit();
                return [
                    "status"=>true,
                    "message"=>"Enregistrement effectuée avec succée",
                    "id"=> $tronc->id
                ];
            } catch (\Throwable $th) {
                DB::rollback();
                return [
                    'status'=>false,
                    'message'=>$th->getMessage(),
                    'srr'=>$th
                ];
            }

        }
    }


    public function journal($date=''){
        if($date==''){
            $date=now()->format('Y-m-d');
        }
        $produits=BoisProduit::whereDate('couper',$date)
                             ->orderBy('couper','desc')
                             ->get();
        return [
            "status"=>true,
            'message'=>'',
            'data'=>$produits
        ];
    }

    public function deleteCouper(Request $request,$produitId){
        $request->input('id',$produitId);
        $validation=Validator::make($request->all(),[
            'id'=>['exists:bois_produits,id'],
        ]);
        $validation->after(function($validator)use($produitId){
            $produit=BoisProduit::find($produitId);


            if($produit->couper==null){
                $validator->errors()->add('id',"Le tronc n'est pas coupé $produitId");
            }
        });
        if($validation->fails()){
            return ResponseAjaxValidation::validate($validation);
        }
        else{
            DB::beginTransaction();
            try {
                $produit=BoisProduit::find($produitId);
                $ligneVente=LigneVente::where('bois_produit_id',$produitId)->first();
                if($ligneVente->is_tv){
                    $vente=Vente::find($ligneVente->vente_id);
                    if($vente->ligne_ventes->count()==1){
                        $lignePaiement= LignePaiement::where('vente_id',$vente->id)->get();
                        if($lignePaiement->count()==0){
                            $vente->delete();
                        }
                    }
                    else{
                        $ligneVente->delete();
                    }

                }
                $produit->couper=null;
                $produit->update();
                DB::commit();
                return [
                    "status"=>true,
                    'message'=>$produit->id.' - '.$produit->identifiant,

                ];
            } catch (\Throwable $th) {
                DB::rollback();
                return [
                    "status"=>true,
                    'message'=>'Probleme suppresion',
                    'error'=>$th->getMessage()
                ];
            }

        }
    }
}
