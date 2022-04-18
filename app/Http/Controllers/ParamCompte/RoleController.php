<?php

namespace App\Http\Controllers\ParamCompte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Npl\Brique\Models\Objet as ModelsObjet;
use Npl\Brique\Models\RoleObjet as ModelsRoleObjet;
use Validator,DB,DataTables,Auth;

class RoleController extends Controller
{

    public function __construct(){
        // $this->middleware('auth');
        // $this->middleware('droit:bois,r')->only('index','getData');
        // $this->middleware('droit:bois,c')->only('store','create');
        // $this->middleware('droit:bois,u')->only('update','archiverMany','desarchiverMany','archiver','desarchiver','destroy');

    }
    /**
     * retourn la liste de roles selon les parametre du request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(Request $request,$filter=""){
        $validator = Validator::make($request->all(),[
            'nom'=>'max:200',
            'all'=>'max:100',
            'filter'=>'max:100'
        ]);
        $roles=Role::select();

        switch($filter){
            case 'archiver':
                $roles->where('archiver',1);
                break;
            default :
                $roles->where('archiver',0);

        }

        if($request->tous){
            $roles->where('nom','like','%'.$request->tous.'%');
        }

        $message="";
        $status="true";
        if($validator->fails()){
            $roles=[];
            $message="Les données ne sont pas valides";
            $status=false;
        }
        else{
            $roles=$roles->get();
        }

        return DataTables::of($roles)
                ->addColumn("nbr_user",function($role){
                    return User::where('role_id',$role->id)->count().' utilisateur(s)';
                })
                ->addColumn("nom_role",function($role){
                    return view('npl::components.links.simple')
                    ->with('url',url("param-compte/roles/".$role->id))
                    ->with('text',$role->nom)
                    ->with('class','lien-sp');
                })
                ->rawColumns(['nom_role','nbr_user','descripton'])
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
        $roles=Role::where('archiver',0)->get();;
        return view("pages.param-compte.role.liste-role",compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role=new Role;
        $role->id=0;
        return view("pages.param-compte.role.create-role",compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[

            'id'=> 'numeric',
            'nom'=> 'required|max:100',
            'archiver'=> 'max:100',
            'description'=> 'max:250',

            'objet'=> 'array|required',
            'objet.*'=>'numeric',

            'c'=>'array',
            'r.'=>'array',
            'u.'=>'array',
            'd.'=>'array',

            'co.'=>'array',
            'ro.'=>'array',
            'uo.'=>'array',
            'do.'=>'array',

            'c.*'=>'numeric',
            'r.*'=>'numeric',
            'u.*'=>'numeric',
            'd.*'=>'numeric',

            'co.*'=>'numeric',
            'ro.*'=>'numeric',
            'uo.*'=>'numeric',
            'do.*'=>'numeric',


        ];
        $messages=[

        ];


        $validator = Validator::make($request->all(), $rules,$messages);

        $validator->after(function ($validator) use ($request){
            if(isset($request->id) && $request->id!=0){
                if(Role::where('id', $request->id)->doesntExist()){
                    $validator->errors()->add(
                        'id', 'l id du role n existe pas'
                    );
                }
                if(Role::where('nom', $request->nom)->where('id','<>',$request->id)->where('archiver',0)->exists()){
                    $validator->errors()->add(
                        'nom', 'Le nom existe dejadd'
                    );
                }

            }else{
                if(Role::where('nom', $request->nom)->where('archiver',0)->exists()){
                    $validator->errors()->add(
                        'nom', 'Le nom existe deja'
                    );
                }
                $testObject=true;
                foreach($request->objet as $value){
                    if(ModelsObjet::where('id',$value)->doesntExist())
                        $testObject=false;
                }
                if($testObject==false){
                    $validator->errors()->add(
                        'objet', "Des Objets de Role non existants sont detectés "
                    );
                }
            }
        });

        if($validator->fails()){
            return response()->json([
                "status"=>false,
                "message"=>"Certains valeurs du formulaire ne sont pas renseigné ou sont incorrects:",
                'errors'=>$validator->errors()
                ])  ;

        }else{
            DB::beginTransaction();
            try {
                $role = new Role;


                if(isset($request->id)  && $request->id!=0){
                    $role=Role::where('id',$request->id)->first();
                    //$role->update();
                }
                $role->nom=$request->nom;
                $role->archiver=(isset($request->archiver))?0:1;
                $role->description = $request->description;
                $role->done_by_user=(Auth::user())?Auth::user()->id:0;
                $role->save();
                foreach($request->objet as $objet_id){
                    $roleObjet=new ModelsRoleObjet();
                    if($request->id!=0 && ModelsRoleObjet::where('role_id',$role->id)->where('objet_id',$objet_id)->exists()){
                        $roleObjet=ModelsRoleObjet::where('role_id',$role->id)->where('objet_id',$objet_id)->first();
                    }
                    else{
                        $roleObjet->role_id=$role->id;
                        $roleObjet->objet_id=$objet_id;
                        $roleObjet->done_by_user=Auth::user()->id;
                    }
                    $roleObjet->role_id;
                    $roleObjet->r=(isset($request->r) && in_array($objet_id,$request->r))?1:0;
                    $roleObjet->c=(isset($request->c) && in_array($objet_id,$request->c))?1:0;
                    $roleObjet->u=(isset($request->u) && in_array($objet_id,$request->u))?1:0;
                    $roleObjet->d=(isset($request->d) && in_array($objet_id,$request->d))?1:0;

                    $roleObjet->ro=(isset($request->ro) && in_array($objet_id,$request->ro))?1:0;
                    $roleObjet->co=(isset($request->co) && in_array($objet_id,$request->co))?1:0;
                    $roleObjet->uo=(isset($request->uo) && in_array($objet_id,$request->uo))?1:0;
                    $roleObjet->do=(isset($request->do) && in_array($objet_id,$request->do))?1:0;
                    $roleObjet->done_by_user=1;
                    $roleObjet->save();
                }
                DB::commit();
                return response()->json([
                    "status"=>true,
                    "id"=>$role->id,
                    "message"=>"Enregistement du role effectuée avec succès",
                    'errors'=>''
                    ])  ;
            } catch (\Exception $ex) {
                DB::rollBack();
                throw $ex;
                return response()->json([
                    "status"=>false,
                    "message"=>"Quelque chose s'est mal passé lors de l'enregistrement. Veuillez  réessayer plus tard!",
                    'data'=>$ex->getMessage(),
                 ])  ;
            }


        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $role=Role::where('id',$id)->first();
        if($role)
            return view("pages.param-compte.role.create-role",compact('role'));
        else
            return abort(404);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validator=Validator::make(['id',$id],
        [
            'id'=>['numeric','exists:App\Models\Role,id',
            new \Npl\Brique\Rules\DbDependance('boutique_users','role_id',[['activer',1]])]
        ]);

        if($validator->fails()){
            return response()->json(\Npl\Brique\Http\ResponseAjax\Validation::validate($validator));
        }
        else{
            return response()->json(\Npl\Brique\Http\ResponseAjax\DeleteRow::one('roles',$id));

        }
    }

    public function destroyMany(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'role_select'=>'array|required',
            'role_select.*'=>['numeric','exists:App\Models\Role,id',
                              new \Npl\Brique\Rules\DbDependance('boutique_users','role_id',[['activer',1]])]
        ]);

        if($validator->fails()){
            return response()->json(\Npl\Brique\Http\ResponseAjax\Validation::validate($validator));
        }
        else{
            return response()->json(\Npl\Brique\Http\ResponseAjax\DeleteRow::many('roles',$request->role_select));

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
            'id'=>['numeric','exists:App\Models\Role,id']
        ]);

        if($validator->fails()){
            return \Npl\Brique\Http\ResponseAjax\Validation::validate($validator);
        }
        else{
            return \Npl\Brique\Http\ResponseAjax\UpdateRow::manyForOnAttr('roles',[$id],
            ['archiver'=>$isAchived],
            'messages.nbr_update');
        }
    }

    private function abstractArchiverMany(Request $request,$isAchived){
        $validator=Validator::make($request->all(),
        [
            'role_select'=>'array|required',
            'role_select.*'=>['numeric','exists:App\Models\Role,id']
        ]);
        if($validator->fails()){
            return \Npl\Brique\Http\ResponseAjax\Validation::validate($validator);
        }
        else{
            return \Npl\Brique\Http\ResponseAjax\UpdateRow::manyForOnAttr('roles',$request->role_select,
                                                                                            ['archiver'=>$isAchived],
                                                                                            'message.nbr_update');
        }
    }


}
