<?php

namespace App\Http\Controllers;

use App\ModelHaut\GenIdPlanche;
use App\ModelHaut\Planche;
use App\Models\EpaisseurBois;
use App\Models\User;
use Illuminate\Http\Request;
use Npl\Brique\Http\ResponseAjax\DeleteRow;
use Npl\Brique\Rules\PositiveRule;
use Npl\Brique\Http\ResponseAjax\Validation as ResponseAjaxValidation;
use Npl\Brique\Rules\DbDependance;
use Npl\Brique\Util\Controller\ArchiverTrait;
use Npl\Brique\Util\DataBases\DoneByUser;
use Npl\Brique\Util\HydrateFacade;
use Npl\Brique\Http\ResponseAjax\Validation;



use Validator,DB,DataTables;

class PlancheController extends Controller
{
    use ArchiverTrait;

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('droit:planche,r')->only('index','getData');
        $this->middleware('droit:planche,c')->only('store','create');
        $this->middleware('droit:planche,u')->only('update');
        $this->middleware('droit:planche,d')->only('destroy');

    }

    public function getInfos(){
        return [
            'model'=>'Planche',
            'archived_attribute'=>'archived',
            'tableName'=>'planche'
        ];
    }

    public function getData(Request $request,$filter=""){
        $validator = Validator::make($request->all(),[
            'prix'=>[new PositiveRule],
            'tous'=>'max:100',
            'filter'=>'max:100'
        ]);
        $planche=Planche::query()->select()->orderBy("m3",'asc');
        switch($filter){


        }

        if($request->has('tous')){
            $planche->where('m3','like',$request->tous.'%');
        }
        $message="";
        $status="true";
        if($validator->fails()){
            $planche=[];
            $message="Les données ne sont pas valides";
            $status=false;
        }
        else{
            $planche=$planche->get();
        }

        return DataTables::of($planche)
                 ->addColumn("m3_f",function($planche){
                    return view('npl::components.links.simple')
                    ->with('url',url("planche/".$planche->id))
                    ->with('text',$planche->m3.' m3')
                    ->with('class','lien-sp');
                 })
                 ->addColumn("largueur_f",function($planche){
                     if($planche->largueur && $planche->largueur>0){
                        return number_format($planche->largueur,'2',',',' ')
                        .view('npl::components.bagde.badge')
                        ->with('text','m')
                        ->with('class','badge-danger');
                     }
                     else{
                         return 'non renseigné';
                     }

                 })
                ->addColumn("epaisseur_f",function($planche){
                        $epaisseur= EpaisseurBois::where('id',$planche->epaisseur_bois_id)->first();
                        $ep=number_format($planche->epaisseur_bois_id,'2',',',' ');
                        if($epaisseur){
                            $ep=$epaisseur->nom.' / '.$ep;
                        }
                        return $ep
                        .view('npl::components.bagde.badge')
                        ->with('text','m')
                        ->with('class','badge-success');

                })

                ->addColumn("longueur_f",function($planche){
                    if($planche->longueur && $planche->longueur>0){
                        return number_format($planche->longueur,'2',',',' ')
                        .view('npl::components.bagde.badge')
                        ->with('text','m')
                        ->with('class','badge-success');
                    }
                    else{
                        return 'non renseigné';
                    }
                 })
                 ->addColumn("quantite_f",function($planche){

                        return number_format($planche->quantite,'0',',',' ')
                        .view('npl::components.bagde.badge')
                        ->with('text','unité')
                        ->with('class','badge-warning');

                 })
                ->addColumn("bois",function($planche){
                    return $planche->bois->name;
                })
                ->addColumn("utilisateur",function($planche){
                    $user=User::where('id',$planche->done_by_user)->first();
                    if($user->id){
                        return $user->name;
                    }
                    return '';
                })
                ->addColumn("created_at_f",function($planche){
                    return $planche->created_at->format('d-m-Y H:i');
                })
                ->addColumn("updated_at_f",function($planche){
                    return $planche->updated_at->format('d-m-Y H:i');
                })
                ->rawColumns(['m3_f','longueur_f','largueur_f','epaisseur_f','bois','quantite_f','created_at_f','updated_at_f'])
                ->with('message',$message)
                ->with('status',$status)
                ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.planche.liste');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $planche = Planche::newPlanche();
        return view('pages.planche.create',compact('planche'));
    }

    public function memeValidation(){
        return [
            'm3'=>['required',new PositiveRule],
            "largueur"=>[new PositiveRule],
            "longueur"=>[new PositiveRule],
            "epaisseur"=>[new PositiveRule],
            "quantite"=>['required',new PositiveRule],
            "bois"=>['required','exists:bois,id'],

        ];
    }

    public function save(Request $request,Array $validationArray,$hydrateArray,$dataBaseMethod,$id=0){
        $validator=Validator::make($request->all()+['id'=>$id],$validationArray);

        if($validator->fails()){
            return ResponseAjaxValidation::validate($validator);
        }
        else{
            DB::beginTransaction();
            try {
                $planche= Planche::newPlanche();
                $is_resem=false;
                if($id>0){
                    $planche=Planche::get($id);
                }
                else{
                    $resem=Planche::resemblance($request->m3,$request->longueur,$request->largueur,$request->epaisseur);
                    if($resem){
                        $planche=$resem;
                        $is_resem=true;
                    }
                }

                HydrateFacade::make($planche,$request,$hydrateArray);

                if($is_resem){
                    $planche->quantite+=$request->quantite;
                }
                else{
                    $planche->quantite=$request->quantite;
                }

                DoneByUser::inject($planche);
                $planche->$dataBaseMethod();

                DB::commit();
                return [
                    "status"=>true,
                    "message"=>"Enregistrement effectuée avec succée",
                    "id"=> $planche->id
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
        $arrrayHydrate=['m3','largueur','longueur','epaisseur_bois_id'=>'epaisseur','bois_id'=>'bois'];
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

        $planche=Planche::get($id);
        if($planche->archived!=0){
            return abort(404,"Planche Deja Vendu");
        }
        else{
            return view("pages.planche.create",compact('planche'));
        }
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
        $arrrayHydrate=['m3','largueur','longueur','epaisseur_bois_id'=>'epaisseur','bois_id'=>'bois'];
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
            'planche_select'=>'array|required',
            'planche_select.*'=>['numeric',"exists:bois_produits,id",
                    new DbDependance('ligne_ventes','bois_produit_id',[])],
        ]);

        if($validator->fails()){
            return response()->json(Validation::validate($validator));
        }
        else{
            return response()->json(DeleteRow::many('bois_produits',$request->planche_select));

        }
    }
}
