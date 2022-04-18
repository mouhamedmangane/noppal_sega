<?php

namespace App\Http\Controllers;

use App\ModelHaut\GenIdTronc;
use App\ModelHaut\Tronc;
use App\ModelHaut\VenteHaut;
use App\Models\BoisProduit;
use App\Models\LigneVente;
use App\Models\User;
use App\Models\Vente;
use Exception;
use Illuminate\Http\Request;
use Npl\Brique\Http\ResponseAjax\DeleteRow;
use Npl\Brique\Rules\PositiveRule;
use Npl\Brique\Http\ResponseAjax\Validation as ResponseAjaxValidation;
use Npl\Brique\Util\Controller\ArchiverTrait;
use Npl\Brique\Util\DataBases\DoneByUser;
use Npl\Brique\Util\HydrateFacade;
use Npl\Brique\Http\ResponseAjax\Validation;
use Npl\Brique\Rules\DbDependance;
use Npl\Brique\Util\NplFilter;
use Validator,DB,DataTables;

class TroncController extends Controller
{
    use ArchiverTrait;

     public function __construct(){
        $this->middleware('auth');
        $this->middleware('droit:tronc,r')->only('index','getData');
        $this->middleware('droit:tronc,c')->only('store','create');
        $this->middleware('droit:tronc,u')->only('update','archiverMany','desarchiverMany','archiver','desarchiver','destroy');

    }

    public function getInfos(){
        return [
            'model'=>'Tronc',
            'archived_attribute'=>'archived',
            'tableName'=>'tronc'
        ];
    }

    public function getData(Request $request,$filter=""){
        $validator = Validator::make($request->all(),[
            'prix'=>[new PositiveRule],
            'tous'=>'max:100',
            'filter'=>'max:100'
        ]);
        $tronc=Tronc::query()->select();
        switch($filter){
            case 'archiver':
                $tronc->where('archived',1);
                break;
            default :
                $tronc->where('archived',0);

        }
        //selection bois
        $tronc->where(function($query)use($request){
            if($request->has('bois') && !empty($request->bois)){
                $query->whereIn('bois_id',$request->bois['op']);
            }

        });
        //nombre de kl
        $tronc->where(function($query)use($request){
            NplFilter::interval($query,$request,'kg','poids');
        });

        $tronc->where(function($query)use($request){
            NplFilter::interval($query,$request,'date_creation','created_at','datetime');
        });

        if($request->has('tous')){
            $tronc->where('identifiant','like',$request->tous.'%');
        }
        $message="";
        $status="true";
        if($validator->fails()){
            $tronc=[];
            $message="Les données ne sont pas valides";
            $status=false;
        }
        else{
            $tronc=$tronc->get();
        }

        $total_kl_tronc=$tronc->sum('poids');
        $total_tronc=$tronc->count();
        return DataTables::of($tronc)
                 ->addColumn("identifiant_f",function($tronc){
                    $text=view('npl::components.links.simple')
                    ->with('url',url("tronc/".$tronc->id))
                    ->with('text',$tronc->identifiant)
                    ->with('class','lien-sp');
                    if($tronc->archived==1){
                        $ligneVente=LigneVente::join('bois_produits','ligne_ventes.bois_produit_id',"bois_produits.id")
                                                ->where('bois_produits.id',$tronc->id)
                                                ->first();
                        $text.=" -> ".view('npl::components.links.simple')
                        ->with('url',url("vente/".$ligneVente->vente_id))
                        ->with('text',"VS-".$ligneVente->vente_id."-".$ligneVente->vente->getName())
                        ->with('class','lien-sp text-success');
                    }
                    return $text;
                 })
                 ->addColumn("diametre_f",function($tronc){
                     if($tronc->diametre && $tronc->diametre>0){
                        return number_format($tronc->diametre,'2',',',' ')
                        .view('npl::components.bagde.badge')
                        ->with('text','m')
                        ->with('class','badge-danger');
                     }
                     else{
                         return 'non renseigné';
                     }

                 })
                ->addColumn("poids_f",function($tronc){
                        return number_format($tronc->poids,'2',',',' ')
                        .view('npl::components.bagde.badge')
                        ->with('text','Kg')
                        ->with('class','badge-success');

                })

                ->addColumn("longueur_f",function($tronc){
                    if($tronc->longueur && $tronc->diametre>0){
                        return number_format($tronc->longueur,'2',',',' ')
                        .view('npl::components.bagde.badge')
                        ->with('text','m')
                        ->with('class','badge-success');
                    }
                    else{
                        return 'non renseigné';
                    }
                 })
                ->addColumn("bois",function($tronc){
                    return $tronc->bois->name;
                })
                ->addColumn("utilisateur",function($tronc){
                    $user=User::where('id',$tronc->done_by_user)->first();
                    if($user->id){
                        return $user->name;
                    }
                    return '';
                })
                ->addColumn("created_at_f",function($tronc){
                    return $tronc->created_at->format('d-m-Y H:i');
                })
                ->addColumn("updated_at_f",function($tronc){
                    return $tronc->updated_at->format('d-m-Y H:i');
                })
                ->rawColumns(['identifiant_f','longueur_f','poids_f','diametre_f','bois','created_at_f','updated_at_f'])
                ->with('message',$message)
                ->with('status',$status)
                ->with('total_kl_tronc',number_format($total_kl_tronc,0,'.',' '))
                ->with('total_tronc',$total_tronc)
                ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.tronc.liste');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tronc = Tronc::newTronc();
        return view('pages.tronc.create',compact('tronc'));
    }

    public function memeValidation(){
        return [
            'identifiant'=>"max:10",
            "poids"=>['required',new PositiveRule],
            "longueur"=>[new PositiveRule],
            "diametre"=>[new PositiveRule],
            "coef"=>[new PositiveRule],
            "bois"=>['required','exists:bois,id'],

        ];
    }

    public function save(Request $request,Array $validationArray,$hydrateArray,$dataBaseMethod,$id=0){
        $validator=Validator::make($request->all()+['id'=>$id],$validationArray);
        $validator->after(function($validator)use($request,$id){
            if(!empty($request->identifiant)
                && Tronc::query()->where('archived',0)->where('identifiant',$request->identifiant)->where('id','<>',$id)->exists()){
                    $iden=$request->identifiant;
                    $validator->errors()->add(
                        'identifiant', "l' identifiant  $iden existe déja dans le stock !"
                    );
            }
        });
        if($validator->fails()){
            return ResponseAjaxValidation::validate($validator);
        }
        else{
            DB::beginTransaction();
            try {
                $modify_vente=false;
                $tronc= Tronc::newTronc();
                $enleverTronc=false;
                if($id>0){
                    $tronc=Tronc::get($id);
                    if(trim($tronc->identifiant)!= trim($request->identifiant)){
                        GenIdTronc::remettre($tronc->identifiant);
                        $enleverTronc=true;
                    }
                    if($tronc->archived==1){
                        $modify_vente=true;
                    }
                }
                else{
                    $enleverTronc=true;
                }


                HydrateFacade::make($tronc,$request,$hydrateArray);
                if($request->has('coef')){
                    $tronc->poids= $request->coef * $request->poids;
                }
                if($id==0 && empty($tronc->identifiant)){
                    $tronc->identifiant=GenIdTronc::newId();
                    $enleverTronc=true;
                    if(Tronc::query()->where('archived',0)
                     ->where('identifiant',$tronc->identifiant)->where('id','<>',$id)->exists()){
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
                    "id"=> $tronc->id
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arrayValidation=$this->memeValidation()+[];
        $arrrayHydrate=['identifiant','poids','longueur','bois_id'=>'bois'];
        $response=$this->save($request,$arrayValidation,$arrrayHydrate,'save');
        return response()->json($response);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $tronc=Tronc::get($id);
        //Tronc::updatePrixUnitaire();

        return view("pages.tronc.create",compact('tronc'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $arrayValidation=$this->memeValidation()+[
            'id'=>"exists:bois_produits,id"
        ];
        $arrrayHydrate=['identifiant','poids','longueur','bois_id'=>'bois'];
        $response=$this->save($request,$arrayValidation,$arrrayHydrate,'update',$id);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function destroyMany(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'tronc_select'=>'array|required',
            'tronc_select.*'=>['numeric',"exists:bois_produits,id",
                    new DbDependance('ligne_ventes','bois_produit_id',[])],
        ]);

        if($validator->fails()){
            return response()->json(Validation::validate($validator));
        }
        else{
            return response()->json(DeleteRow::many('bois_produits',$request->tronc_select));

        }
    }
}
