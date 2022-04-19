<?php

namespace App\Http\Controllers\ParamCompte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Npl\Brique\Util\HydrateFacade;
use Npl\Brique\Util\ImageFactory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use DB,DataTables,Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
            $users=User::select();
            switch($filter){
                case 'archiver':
                    $users->where('archived',1);
                    break;
                default :
                    $users->where('archived',0);

            }

            if($request->has('tous')){
                $users->where('name','like',$request->tous.'%');
            }

            $message="";
            $status="true";
            if($validator->fails()){
                $users=[];
                $message="Les données ne sont pas valides";
                $status=false;
            }
            else{
                $users=$users->get();
            }

        return DataTables::of($users)
                ->addColumn("nom",function($user){
                    return view('npl::components.links.simple')
                    ->with('src',asset("images/users/".$user->photo))
                    ->with('url',url("param-compte/users/".$user->id))
                    ->with('text',$user->name)
                    ->with('class','lien-sp');
                })
                ->addColumn("role",function($user){
                    $role=Role::where('id',$user->role_id)->first();
                    return ($role)?$role->nom:'Ancun';
                })
                ->addColumn("created_at_f",function($user){

                    return ($user->created_at)?$user->created_at->format('d-m-Y H:i'):'non defini';
                })
                ->addColumn("updated_at_f",function($user){
                    return ($user->updated_at)?$user->updated_at->format('d-m-Y H:i'):'non-defini';
                })
                ->rawColumns(['name','nom','email','tel','created_at_f','updated_at_f'])
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
        $users=User::all();
        return view("pages.param-compte.user.liste",compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user= new User;
        return view("pages.param-compte.user.create",compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response=$this->save($request,$this->memeValidationSave()+[
            "login"=>"required|max:100|unique:users,email",
            "pwd"=>"required|confirmed|max:100",
            ],
            ['name'=>'nom','role_id','email'=>'login','password'=>'pwd','ncni','tel'],
            'save'
        );

        return response()->json($response);

    }

    public function save(Request $request,Array $validationArray,$hydrateArray,$dataBaseMethod,$id=0){
         $validator = Validator::make($request->all()+['id'=>$id], $validationArray);
        if($validator->fails()){
            return \Npl\Brique\Http\ResponseAjax\Validation::validate($validator);
        }
        else{
            DB::beginTransaction();
            try {
                $user=new User;

                if($id>0){
                    $user=User::where('id',$id)->first();
                }
                if(Auth::user())
                    $user->done_by_user=Auth::user()->id;
                HydrateFacade::make($user,$request,$hydrateArray);
                ImageFactory::store($request,$user,'photo','images/users',$user->id);
                if($request->filled('pwd')) {
                        $user->password=Hash::make($request->pwd);
                }
                if($user->$dataBaseMethod()){
                }

                DB::commit();

                return [
                    'status'=>true,
                    'message'=>'Enregistrement effectué avec success',
                    'id'=>$user->id
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

    public function memeValidationSave(){

        $tab=[
            "nom"=>"required|max:100",
            "role_id*"=>'numeric|exists:App\Models\Role,id',
            "photo"=>"image",
            'ncni'=>'max:50',
            'tel' =>'max:20'
        ];
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
        $user= User::where('id',$id)->first();
        return view("pages.param-compte.user.create",compact('user'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user= User::where('id',$id);
        return view("pages.param-compte.user.create",compact('user'));
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
            "id"=>"required|numeric|exists:users,id",
            "pwd"=>"confirmed|max:100",
            "login"=>["required","max:100",Rule::unique('users', 'email')->ignore($id),],

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
            'id'=>['numeric','exists:App\Models\User,id']
        ]);

        if($validator->fails()){
            return \Npl\Brique\Http\ResponseAjax\Validation::validate($validator);
        }
        else{
            return \Npl\Brique\Http\ResponseAjax\UpdateRow::manyForOnAttr('users',[$id],
            ['archiver'=>$isAchived],
            'messages.nbr_update');
        }
    }

    private function abstractArchiverMany(Request $request,$isAchived){
        $validator=Validator::make($request->all(),
        [
            'user_select'=>'array|required',
            'user_select.*'=>['numeric','exists:App\Models\User,id']
        ]);
        if($validator->fails()){
            return \Npl\Brique\Http\ResponseAjax\Validation::validate($validator);
        }
        else{
            return \Npl\Brique\Http\ResponseAjax\UpdateRow::manyForOnAttr('users',$request->user_select,
                                                                                            ['archiver'=>$isAchived],
                                                                                            'messages.nbr_update');
        }
    }

}
