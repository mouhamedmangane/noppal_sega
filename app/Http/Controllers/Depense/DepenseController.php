<?php

namespace App\Http\Controllers\Depense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Depense;

use App\Models\Vente;

use DB,DataTables,Validator;
use Npl\Brique\Http\ResponseAjax\DeleteRow;
use Npl\Brique\Http\ResponseAjax\Validation;
use Npl\Brique\Util\DataBases\DoneByUser;

use Npl\Brique\Rules\DbDependance;
use Npl\Brique\Rules\Ninterval;
use Npl\Brique\Rules\NOp;
use Npl\Brique\Rules\NSelect;
use Npl\Brique\Util\Controller\ArchiverTrait;
use Npl\Brique\Util\HydrateFacade;
use Npl\Brique\Util\NplFilter;
use Npl\Brique\Rules\PositiveRule;


class DepenseController extends Controller
{
    use ArchiverTrait;

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('droit:depense,r')->only('index','getData');
        $this->middleware('droit:depense,c')->only('store','create');
        $this->middleware('droit:depense,u')->only('update','archiverMany','desarchiverMany','archiver','desarchiver','destroy');

    }

    public function getInfos(){
        return [
            'model'=>'Depense'
        ];
    }
    public function getData(Request $request,$filter=""){
            $validator = Validator::make($request->all(),[
                'nom'=>'max:200',
                'type_client'=>[new NSelect()],
                'tel'=>[new NOp(NOp::NUMBER)],
                'email'=>[new NOp(NOp::TEXT)],
                'date_creation'=>[new Ninterval(Ninterval::DATE)],
                'all'=>'max:100',
                'filter'=>'max:100'
            ]);
            $depenses=Depense::select(DB::raw('distinct depenses.id,depenses.*'))
                              ->leftJoin('ligne_achat_p_s','ligne_achat_p_s.depense_id','depenses.id')
                              ->leftJoin('achats','ligne_achat_p_s.achat_id','achats.id')
                              ->leftJoin('contacts','achats.fournisseur_id','contacts.id')
                              ->orderBy('created_at','desc');
            $depenses->where(function($query)use($filter,$request){

                switch($filter){
                    case "all":break;
                    case 'today':
                        $query->where('depenses.created_at','>=',now()->format("Y-m-d 00:00"));
                        break;
                    case 'quinze':
                        $query->where('depenses.created_at','>=',date("Y-m-d 00:00",strtotime('-15 day',time())));
                        break;
                    default :
                        if(!$request->has('tous') || empty($request->tous)){
                            $query->whereMonth('depenses.created_at',now()->format('m'));
                            $query->whereYear('depenses.created_at',now()->format('Y'));
                        }



                }

            });
            // filter telephone
            // $depenses->where(function($query)use($request){
            //     NplFilter::one($query,$request,'tel','telephones.numero','number');
            //     NplFilter::one($query,$request,'tel','telephones.indicatif','number','orWhereRaw');

            // });

            // filter mail
            // NplFilter::one($depenses,$request,'email','depenses.email','text','Where');
            // filter fonction
            // NplFilter::one($depenses,$request,'fonction','depenses.fonction','text','Where');

             //filter select type
            // $depenses->where(function($query)use($request){
            //     NplFilter::select($query,$request,'type_depense',[
            //         'client'=>['depenses.is_client','=','1'],
            //         'fournisseur'=>['depenses.is_fournisseur','=','1'],
            //     ]);
            // });

            //somme
            $depenses->where(function($query)use($request){
                NplFilter::interval($query,$request,'somme','depenses.somme');
            });
             //filter date creation
             $depenses->where(function($query)use($request){
                NplFilter::interval($query,$request,'date_creation','depenses.created_at','date');
            });

            if($request->has('tous') && !empty($request->tous)){
                if(!empty($request->tous)){
                    $request->tous=str_replace('ds-','',$request->tous);
                }
                $depenses->whereRaw("concat(cast(depenses.id as varchar(49))) like '".$request->tous."%' ");
                $depenses->orWhere('depenses.id','like','%'.$request->tous.'%');
                $depenses->orwhere('depenses.description','like','%'.$request->tous.'%');
                $depenses->orWhere('contacts.nom','like','%'.$request->tous.'%');
                $depenses->orWhere('depenses.type_depense_id','like','%'.$request->tous.'%');
            }

            $message="";
            $status="true";
            if($validator->fails()){
                $depenses=[];
                $message="Les données ne sont pas valides";
                $status=false;
            }
            else{
                $depenses=$depenses->distinct('depenses.id')->get();
            }


        return DataTables::of($depenses)
                ->addColumn("numero",function($depense){
                    return view('npl::components.links.simple')
                            ->with('url',url("depense/".$depense->id))
                            ->with('text','DS-'.$depense->id)
                            ->with('class','lien-sp');
                })
                ->addColumn('somme_f',function($depense){
                    return number_format($depense->somme,0,","," ")
                    .view('npl::components.bagde.badge')
                    ->with('text',"FCFA")
                    ->with('class','badge-success');;
                })
                ->addColumn("description",function($depense){
                    //dd($depense->ligneAchatP()->dd());
                    if($depense->ligneAchatP){
                        return 'Achat N°'.view('npl::components.links.simple')
                        ->with('url',url("achat/".$depense->ligneAchatP->achat_id))
                        ->with('text',$depense->ligneAchatP->achat->fournisseur->nom.' - AS- '.$depense->ligneAchatP->achat_id)
                        ->with('class','lien-sp');
                    }
                    else{
                        return $depense->description;
                    }

                })
                ->addColumn("type_depense_f",function($depense){
                    //dd($depense->ligneAchatP()->dd());
                    if($depense->ligneAchatP){
                        return view('npl::components.bagde.badge')
                        ->with('text',$depense->type_depense_id)
                        ->with('class','badge-warning');
                    }
                    else{
                        return $depense->type_depense_id;
                    }

                })
                ->addColumn('note',function($depense){
                    if($depense->note){
                        return $depense->note;
                    }
                    else{
                        return 'aucun';
                    }

                })
                ->addColumn("created_at_f",function($user){

                    return ($user->created_at)?$user->created_at->format('d-m-Y H:i'):'non defini';
                })
                ->addColumn("updated_at_f",function($user){
                    return ($user->updated_at)?$user->updated_at->format('d-m-Y H:i'):'non-defini';;
                })
                ->rawColumns(['numero','description','type_depense_f','note','somme_f','created_at_f','updated_at_f'])
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
        $depenses=Depense::all();
        return view("pages.depense.liste",compact('depenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depense=new Depense;
        $vente=null;
        return view("pages.depense.create",compact('depense','vente'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response=$this->save(
            $request,
            $this->memeValidationSave(0),
            ['somme','description','note','type_depense_id'=>"type_depense"],
            0
        );

        return response()->json($response);

    }

    public function save(Request $request,Array $validationArray,$hydrateArray,$id=0){

        $validator = Validator::make($request->all()+['id'=>$id], $validationArray);
        $validator->after(function($validator)use($request){
            if($request->has('vente_id')){
                if(!Vente::where('id',$request->vente_id)->exists()){
                    $validator->errors()->add('vente','la vente n existe pas, peut etre elle est suprimer pas un autre utilisateur');
                }
            }
        });
        if($validator->fails()){
            return Validation::validate($validator);
        }
        else{
            DB::beginTransaction();
            try {
                $depense=new Depense;
                $dataBaseMethod='save';
                if($id>0){
                    $depense=Depense::where('id',$id)->first();
                    $dataBaseMethod='update';

                }
                HydrateFacade::make($depense,$request,$hydrateArray);
                DoneByUser::inject($depense);
                $depense->$dataBaseMethod();

                DB::commit();

                return [
                    'status'=>true,
                    'message'=>'Enregistrement effectué avec success',
                    'id'=>$depense->id
                ];
            } catch (\Throwable $th) {
                DB::rollback();

                return [
                    'status'=>false,
                    'message'=>__('messages.erreur_inconnu').' '.__('messages.operation_encore'),
                    'srr'=>$th
                ];
            }

        }

    }



    public function memeValidationSave($id){

        $tab=[
            "type_depense"=>'exists:type_depenses,id',
            "description"=>"max:150",
            "note"=>"max:150",
            'somme'=>[new PositiveRule],
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
        $depense= Depense::where('id',$id)->first();
        return view("pages.depense.voir",compact('depense'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $depense= Depense::where('id',$id)->first();
        $vente=null;
        return view("pages.depense.create",compact('depense','vente'));
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
        $response=$this->save(
            $request,
            $this->memeValidationSave($id),
            ['somme','description'=>'description/exist','note','type_depense_id'=>"type_depense"],
            $id
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
            'depense_select'=>'array|required',
            'depense_select.*'=>['numeric',new DbDependance('ligne_achat_p_s','depense_id',[])],
        ]);

        if($validator->fails()){
            return response()->json(Validation::validate($validator));
        }
        else{
            return response()->json(DeleteRow::many('depenses',$request->depense_select));

        }
    }



}
