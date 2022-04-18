<?php

namespace App\Http\Controllers;

use App\Models\Bois;
use App\ModelHaut\Planche;
use App\ModelHaut\Tronc;
use App\Models\User;
use Illuminate\Http\Request;
use Npl\Brique\Http\ResponseAjax\DeleteRow;
use Npl\Brique\Http\ResponseAjax\Validation as ResponseAjaxValidation;
use Npl\Brique\Rules\DbDependance;
use Npl\Brique\Rules\PositiveRule;
use Npl\Brique\Util\Controller\ArchiverTrait;
use Npl\Brique\Util\DataBases\DoneByUser;
use Npl\Brique\Util\HydrateFacade;
use Npl\Brique\Http\ResponseAjax\Validation;

use Validator,DB,DataTables;

class BoisController extends Controller
{
    use ArchiverTrait;

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('droit:bois,r')->only('index','getData');
        $this->middleware('droit:bois,c')->only('store','create');
        $this->middleware('droit:bois,u')->only('update','archiverMany','desarchiverMany','archiver','desarchiver','destroy');

    }

    public function getInfos(){
        return [
            'model'=>'Bois',
            'archived_attribute'=>'archived',
            'tableName'=>'bois'
        ];
    }

    public function getData(Request $request,$filter=""){
        $validator = Validator::make($request->all(),[
            'prix'=>[new PositiveRule],
            'tous'=>'max:100',
            'filter'=>'max:100'
        ]);
        $bois=Bois::select();
        switch($filter){
            case 'archiver':
                $bois->where('archived',1);
                break;
            default :
                $bois->where('archived',0);

        }

        if($request->has('tous')){
            $bois->where('name','like',$request->tous.'%');
        }

        $message="";
        $status="true";
        if($validator->fails()){
            $bois=[];
            $message="Les données ne sont pas valides";
            $status=false;
        }
        else{
            $bois=$bois->get();
        }

        return DataTables::of($bois)
                ->addColumn("nom",function($bois){
                    return view('npl::components.links.simple')
                    ->with('url',url("bois/".$bois->id))
                    ->with('text',$bois->name)
                    ->with('class','lien-sp');
                })
                ->addColumn("prix_planche_f",function($bois){
                    return number_format($bois->prix_planche,'0',' ',' ')
                        .view('npl::components.bagde.badge')
                        ->with('text','FCFA')
                        ->with('class','badge-danger');
                 })
                 ->addColumn("prix_tronc_f",function($bois){
                    return number_format($bois->prix_tronc,'0',' ',' ')
                    .view('npl::components.bagde.badge')
                    ->with('text','FCFA')
                    ->with('class','badge-danger');
                 })
                ->addColumn("total_tronc",function($bois){
                   $total_kl= Tronc::query()->where('archived',0)->where('bois_id',$bois->id)->sum('poids');
                   return number_format($total_kl,0,' ',' ').' '.view('npl::components.bagde.badge')
                   ->with('text','Kg')
                   ->with('class','badge-success');
                })
                ->addColumn("count_tronc",function($bois){
                   $total_kl= Tronc::query()->where('archived',0)->where('bois_id',$bois->id)->count();
                   return number_format($total_kl,0,' ',' ').' '.view('npl::components.bagde.badge')
                   ->with('text','unite')
                   ->with('class','badge-warning');
                })

                ->addColumn("total_planche",function($bois){
                    $total_m3= Planche::total_m3();
                    $response="".$total_m3;
                    $response.=view('npl::components.bagde.badge')
                    ->with('text','m3')
                    ->with('class','badge-success');
                    return $response;
                 })
                ->addColumn("ratio_vente",function($bois){
                    return "after";
                })
                ->addColumn("utilisateur",function($bois){
                    $user=User::where('id',$bois->done_by_user)->first();
                    if($user->id){
                        return $user->name;
                    }
                    return '';
                })
                ->addColumn("created_at_f",function($bois){
                    return $bois->created_at->format('d-m-Y H:i');
                })
                ->addColumn("updated_at_f",function($bois){
                    return $bois->updated_at->format('d-m-Y H:i');
                })
                ->rawColumns(['nom','count_tronc','prix_tronc_f','prix_planche_f','total_planche','total_tronc','created_at_f','updated_at_f'])
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
        return view('pages.bois.liste');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bois = new Bois();
        return view('pages.bois.create',compact('bois'));
    }

    public function memeValidation(){
        return [
            'name'=>"max:50",
            "prix_tronc"=>[new PositiveRule],
            "prix_tranche"=>[new PositiveRule],

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
                $bois=new Bois;
                if($id>0){
                    $bois=Bois::where('id',$id)->first();
                }
                HydrateFacade::make($bois,$request,$hydrateArray);
                DoneByUser::inject($bois);
                $bois->$dataBaseMethod();
                DB::commit();
                return [
                    "status"=>true,
                    "message"=>"Enregistrement effectuée avec succée",
                    "id"=> $bois->id
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
        $arrrayHydrate=['name','prix_planche','prix_tronc'];
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
        $bois=Bois::where('id',$id)->first();
        return view("pages.bois.create",compact('bois'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $arrayValidation=$this->memeValidation()+[];
        $arrrayHydrate=['name','prix_planche','prix_tronc'];
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
            'bois_select'=>'array|required',
            'bois_select.*'=>['numeric',new DbDependance('bois_produits','bois_id',[]),],
        ]);

        if($validator->fails()){
            return response()->json(Validation::validate($validator));
        }
        else{
            return response()->json(DeleteRow::many('bois',$request->bois_select));

        }
    }
}
