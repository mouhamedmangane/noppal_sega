<?php

namespace App\Http\Controllers;

use App\Models\EpaisseurBois;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Npl\Brique\Http\ResponseAjax\DeleteRow;
use Npl\Brique\Http\ResponseAjax\Validation as ResponseAjaxValidation;

use Npl\Brique\Rules\PositiveRule;
use Npl\Brique\Util\Controller\ArchiverTrait;
use Npl\Brique\Util\DataBases\DoneByUser;
use Npl\Brique\Util\HydrateFacade;
use Validator,DB,DataTables;
class EpaisseurPlancheController extends Controller
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
            'model'=>'EpaisseurBois',
            'archived_attribute'=>'archived',
            'tableName'=>'epaisseur_bois',
            'selectName'=>'epaisseur_planche_select'
        ];
    }
    public function getData(Request $request,$filter=""){
        $validator = Validator::make($request->all(),[
            'prix'=>[new PositiveRule],
            'tous'=>'max:100',
            'filter'=>'max:100'
        ]);
        $bois=EpaisseurBois::select();
        switch($filter){
            case 'archiver':
                $bois->where('archived',1);
                break;
            default :
                $bois->where('archived',0);

        }

        if($request->has('tous')){
            $bois->where('nom','like',$request->tous.'%');
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
                ->addColumn("id_f",function($epaisseur){
                   return  number_format($epaisseur->id,'2',',',' ').' '
                    .view('npl::components.bagde.badge')
                    ->with('text','cm')
                    ->with('class','badge-primary');
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
                ->rawColumns(['nom','id_f','created_at_f','updated_at_f','utilisateur'])
                ->with('message',$message)
                ->with('status',$status)
                ->toJson();
    }

    public function index()
    {
        $epaisseur= new EpaisseurBois;
        return view('pages.epaisseur_planche.liste',compact('epaisseur'));
    }

    public function store(Request $request){
        $arrayValidation=$this->memeValidation($request)+[];
        $arrrayHydrate=['nom','id'=>'id_new'];
        $response=$this->save($request,$arrayValidation,$arrrayHydrate,'save');
        return response()->json($response);
    }

    public function memeValidation($request){
        return [
            "id"=>[new PositiveRule],
            'nom'=>["max:50",Rule::unique('epaisseur_bois','nom')->ignore($request->id)],
            "id_new"=>[new PositiveRule,Rule::unique('epaisseur_bois','id')->ignore($request->id)],

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
                $epaisseur_bois=new EpaisseurBois;
                if($request->id > 0){
                    $epaisseur_bois=EpaisseurBois::where('id',$request->id)->first();
                    $dataBaseMethod="update";
                }
                //dd($request->all());
                HydrateFacade::make($epaisseur_bois,$request,$hydrateArray);
                DoneByUser::inject($epaisseur_bois);
                $epaisseur_bois->$dataBaseMethod();
                DB::commit();
                return [
                    "status"=>true,
                    "message"=>"Enregistrement effectuée avec succée",
                    "id"=> $epaisseur_bois->id
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



    public function destroyMany(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'epaisseur_planche_select'=>'array|required',
            'epaisseur_planche_select.*'=>['numeric','exists:App\Models\EpaisseurBois,id']
        ]);

        if($validator->fails()){
            return response()->json(ResponseAjaxValidation::validate($validator));
        }
        else{
            return response()->json(DeleteRow::many('epaisseur_bois',$request->epaisseur_planche_select));

        }
    }

    public function get(Request $request){
        $validator =  Validator::make($request->all(),[
            "id"=>"exists:App\Models\EpaisseurBois,id"
        ]);
        if($validator->fails()){
            return response()->json(ResponseAjaxValidation::validate($validator));
        }
        else{
            $epaisseur=EpaisseurBois::where("id",$request->id)->first();
            return response()->json([
                "status"=>true,
                "data"=>$epaisseur,
                "message"=>"reussi"
            ]);
        }
    }


}
