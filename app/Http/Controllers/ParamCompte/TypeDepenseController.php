<?php

namespace App\Http\Controllers\ParamCompte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypeDepense;
use App\Models\Role;
use Npl\Brique\Util\HydrateFacade;
use Npl\Brique\Util\ImageFactory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use DB,DataTables,Validator;
use Illuminate\Support\Facades\Auth;

class TypeDepenseController extends Controller
{
    public function __construct(){
        // $this->middleware('auth');
        // $this->middleware('droit:bois,r')->only('index','getData');
        // $this->middleware('droit:bois,c')->only('store','create');
        // $this->middleware('droit:bois,u')->only('update','archiverMany','desarchiverMany','archiver','desarchiver','destroy');

    }
    public function getData(Request $request,$filter=""){
            $validator = Validator::make($request->all(),[
                'nom'=>'max:200',
                'all'=>'max:100',
                'filter'=>'max:100'
            ]);
            $typedepenses=TypeDepense::select();
            switch($filter){
                case 'archiver':
                    $typedepenses->where('archived',1);
                    break;
                default :
                    $typedepenses->where('archived',0);

            }

            if($request->has('tous')){
                $typedepenses->where('id','like',$request->tous.'%');
            }

            $message="";
            $status="true";
            if($validator->fails()){
                $typedepenses=[];
                $message="Les données ne sont pas valides";
                $status=false;
            }
            else{
                $typedepenses=$typedepenses->get();
            }

        return DataTables::of($typedepenses)
                ->addColumn("nom",function($typedepense){
                    return $typedepense->id;
                })
                ->addColumn("seuil_f",function($typedepense){
                    if($typedepense->seuil){
                        return
                        view('npl::components.bagde.badge')
                        ->with('text',number_format($typedepense->seuil,0,',',' ')." FCFA")
                        ->with('class','badge-success');
                    }
                    return view('npl::components.bagde.badge')
                    ->with('text',"non défini")
                    ->with('class','badge-warning');
                })
                ->addColumn("created_at_f",function($typedepense){

                    return ($typedepense->created_at)?$typedepense->created_at->format('d-m-Y H:i'):'non defini';
                })
                ->addColumn("updated_at_f",function($typedepense){
                    return ($typedepense->updated_at)?$typedepense->updated_at->format('d-m-Y H:i'):'non-defini';
                })
                ->rawColumns(['nom','seuil_f','created_at_f','updated_at_f'])
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
        $typedepenses=TypeDepense::all();
        return view("pages.param-compte.typedepense.liste",compact('typedepenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typedepense= new TypeDepense;
        return view("pages.param-compte.typedepense.create",compact('typedepense'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response=$this->save($request,$this->memeValidationSave($request->type_depense_id),
            ['id'=>'nom',"seuil"],$request->type_depense_id
        );

        return response()->json($response);

    }


    public function save(Request $request,Array $validationArray,$hydrateArray,$id=0){
         $validator = Validator::make($request->all()+['id'=>$id], $validationArray);
        if($validator->fails()){
            return \Npl\Brique\Http\ResponseAjax\Validation::validate($validator);
        }
        else{
            DB::beginTransaction();
            try {
                $typedepense=new TypeDepense;
                $dataBaseMethod='save';
                if(strlen($id)>0){
                    $typedepense=TypeDepense::where('id',$id)->first();
                    $dataBaseMethod='update';
                }
                HydrateFacade::make($typedepense,$request,$hydrateArray);
                $typedepense->$dataBaseMethod();

                DB::commit();

                return [
                    'status'=>true,
                    'message'=>'Enregistrement effectué avec success',
                    'id'=>$typedepense->id
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

    public function memeValidationSave($id){

        $tab=[
            "nom"=>[Rule::unique('type_depenses','id')->ignore($id)],
        ];
        if(strlen($id)>0){
            $tab['type_depense_id']="exists:type_depenses,id";
        }
        return $tab;
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $typedepense= TypeDepense::where('id',$id)->first();
        return view("pages.param-compte.typedepense.create",compact('typedepense'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $typedepense= TypeDepense::where('id',$id);
        return view("pages.param-compte.typedepense.create",compact('typedepense'));
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
        $request->input('id',$id);
        $response = $this->save($request,$this->memeValidationSave()+[
            "id"=>"required|numeric|exists:typedepenses,id",
            "pwd"=>"confirmed|max:100",
            "login"=>["required","max:100",Rule::unique('typedepenses', 'email')->ignore($id),],

            ],
            ['name'=>'nom','role_id','email'=>'login','password'=>'pwd/exist','ncni','tel'],
            'save',$id
        );

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
            'typedepense_select'=>'array|required',
            'typedepense_select.*'=>['exists:type_depenses,id']
        ]);

        if($validator->fails()){
            return response()->json(\Npl\Brique\Http\ResponseAjax\Validation::validate($validator));
        }
        else{
            return response()->json(\Npl\Brique\Http\ResponseAjax\DeleteRow::many('type_depenses',$request->typedepense_select));

        }
    }

    public function archiver($id){
        return response()->json($this->abstractArchiver($id,1));
    }

    public function desarchiver($id){
        return response()->json($this->abstractArchiver($id,0));
    }

    public function archiverMany(Request $request){
        return response()->json($this->abstractArchiverMany($request,1));
    }

    public function desarchiverMany(Request $request){
        return response()->json($this->abstractArchiverMany($request,0));
    }

    private function abstractArchiver($id,$isAchived)
    {
        $validator=Validator::make(['id',$id],
        [
            'id'=>['numeric','exists:App\Models\TypeDepense,id']
        ]);

        if($validator->fails()){
            return \Npl\Brique\Http\ResponseAjax\Validation::validate($validator);
        }
        else{
            return \Npl\Brique\Http\ResponseAjax\UpdateRow::manyForOnAttr('typedepenses',[$id],
            ['archiver'=>$isAchived],
            'messages.nbr_update');
        }
    }

    private function abstractArchiverMany(Request $request,$isAchived){
        $validator=Validator::make($request->all(),
        [
            'typedepense_select'=>'array|required',
            'typedepense_select.*'=>['numeric','exists:App\Models\TypeDepense,id']
        ]);
        if($validator->fails()){
            return \Npl\Brique\Http\ResponseAjax\Validation::validate($validator);
        }
        else{
            return \Npl\Brique\Http\ResponseAjax\UpdateRow::manyForOnAttr('typedepenses',$request->typedepense_select,
                                                                                            ['archiver'=>$isAchived],
                                                                                            'messages.nbr_update');
        }
    }

}
