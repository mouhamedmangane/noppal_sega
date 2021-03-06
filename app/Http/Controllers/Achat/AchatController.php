<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;
use App\Models\Achat;
use Illuminate\Http\Request;
use Npl\Brique\Rules\NOp;
use Npl\Brique\Rules\NSelect;
use Npl\Brique\Rules\PositiveRule;
use Npl\Brique\Util\DataBases\DoneByUser;
use Npl\Brique\Util\HydrateFacade;
use Npl\Brique\Util\NplFilter;
use Validator,DB,DataTables;

class AchatController extends Controller
{


    public function getData(Request $request,$filter=null,$id_fournisseur=null){
        $validator = Validator::make($request->all(),[
            'tous'=>'max:100',
            'fournisseur'=>[new NOp(NOp::TEXT)],
            'chauffeur'=>[new NOp(NOp::TEXT)],
            'etat'=>[new NSelect()],
            'filter'=>'max:100'
        ]);
        $achats= Achat::select(DB::raw('achats.id,achats.*'))
                 ->orderBy('achats.created_at','desc');
        if($id_fournisseur!=null){
            $achats->where('achats.fournisseur_id',$id_fournisseur);
        }

        $achats->where(function($query)use($filter,$request){
            switch($filter){
                case 'all':
                    break;
                case 'imcomplete':
                    $query->where('achats.poids','<=',0);
                    break;
                case "avance":
                    $tabIds=Achat::select(DB::raw(" achats.id,achats.somme as sm,sum(depenses.somme) as paie "))
                    ->join('ligne_achat_p_s','achats.id','ligne_achat_p_s.achat_id')
                    ->leftJoin('depenses','ligne_achat_p_s.depense_id','depenses.id')
                    ->groupBy('achats.id','sm')
                    ->havingRaw("paie > sm")
                    ->get()
                    ->pluck('id');
                    $query->whereIn("id",$tabIds);
                    break;
                case 'paye':
                    $tabIds=Achat::select(DB::raw(" achats.id,achats.somme as sm,sum(depenses.somme) as paie "))
                    ->join('ligne_achat_p_s','achats.id','ligne_achat_p_s.achat_id')
                    ->leftJoin('depenses','ligne_achat_p_s.depense_id','depenses.id')
                    ->groupBy('achats.id','sm')
                    ->havingRaw("paie = sm")
                    ->get()
                    ->pluck('id');
                    $query->whereIn("id",$tabIds);
                    break;
                case "impaye":
                    $tabIds=Achat::select(DB::raw(" achats.id,achats.somme as sm,sum(depenses.somme) as paie "))
                    ->join('ligne_achat_p_s','achats.id','ligne_achat_p_s.achat_id')
                    ->leftJoin('depenses','ligne_achat_p_s.depense_id','depenses.id')
                    ->groupBy('achats.id','sm')
                    ->havingRaw("paie < sm")
                    ->get()
                    ->pluck('id');

                    $query->whereIn("id",$tabIds);
                     break;

                default :

            }
        });
        //filter select
        // $achats->where(function($query)use($request){
        //     NplFilter::select($query,$request,'etat',[
        //         AchatHaut::COMPLETE=>['achats.etat','like',AchatHaut::COMPLETE],
        //         AchatHaut::ACCOMPTE=>['achats.etat','like',AchatHaut::ACCOMPTE],
        //         AchatHaut::COMMANDE=>['achats.etat','like',AchatHaut::COMMANDE],
        //     ]);
        // });

        //filter contact
        $achats->where(function($query)use($request){
            NplFilter::one($query,$request,'fournisseur','contacts.nom','text','where');
            // NplFilter::one($query,$request,'client','achats.nom','','orWhereRaw');

        });

        //date creation
        $achats->where(function($query)use($request){
            NplFilter::interval($query,$request,'date_creation','achats.created_at','date');
        });

        if($request->has('tous')){
            $achats->where(function($query)use($request){
                if(!empty($request->tous)){
                    $request->tous=str_replace('vs-','',$request->tous);
                }
                $query->whereRaw("concat(cast(achats.id as varchar(49))) like '".$request->tous."%' ");
            });
        }
        $message="";
        $status="true";
        if($validator->fails()){
            $achats=[];
            $message="Les donn??es ne sont pas valides";
            $status=false;
        }
        else{
            $achats=$achats->get();
        }
        // $somme=$achats->sum(function($achat){
        //     return $achat->sumAchat();
        // });
        $data = DataTables::of($achats)

            ->addColumn('fournisseur',function($achat){
                if($achat->fournisseur_id){
                    return $achat->fournisseur->nameAndPhone();
                }
                return "Aucun";
            })
            ->addColumn('chauffeur',function($achat){
                if($achat->chauffeur_id){
                    return $achat->chauffeur->nameAndPhone();
                }
                return "Aucun";
            })
            ->addColumn('somme_f',function($achat){
                return number_format($achat->somme,0,',',' ')." FCFA" ;
            })
            ->addColumn('poids_f',function($achat){
                return number_format($achat->poids,0,',',' ') ." KG" ;
            })

            ->addColumn('ouvert_f',function($achat){
                $html="";
                if($achat->isComplete()){
                    $html.=view('npl::components.bagde.badge')
                    ->with('text',"complete")
                    ->with('class','badge-success');
                }
                else if(!$achat->somme >0 && $achat->restant()<0){
                    $html.=view('npl::components.bagde.badge')
                    ->with('text',"imcomplete")
                    ->with('class','badge-danger');
                }
                else{
                    $html.=view('npl::components.bagde.badge')
                    ->with('text',"s??mi-complete")
                    ->with('class','badge-warning');
                }
                return $html;
            })

            ->addColumn('numeroAchat',function($achat){
                return view('npl::components.links.simple')
                ->with('url',url("achat/".$achat->id))
                ->with('text','AS-'.$achat->id)
                ->with('class','lien-sp');
            })
            ->addColumn('date',function($achat){
                return ($achat->created_at)?$achat->created_at->format('d-m-Y'):'non defini';
            })
            ->addColumn('heure',function($achat){
                return ($achat->created_at)?$achat->created_at->format('H:i:s'):'non defini';
            })
            ->rawColumns(['numeroAchat','chauffeur','ouvert_f','fournisseur','somme_f','date','heure','poids_f'])
            ->with('status',$status)
            ->with('message',$message)
            ->toJson();

        return $data;


    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.achat.liste');
    }

    public function ajaxPush(Request $request){
        if($request->session()->has('achat_form')){
            $achat=$request->session()->get('achat_form');
        }
        else{
            $achat=new Achat();

        }
        HydrateFacade::make($achat,$request,[
            "somme"=>"somme/exist",
            "somme_detail"=>"somme_detail/exist",
            "fournisseur_id"=>'fournisseur/exist',
            "chauffeur_id"=>'chauffeur/exist',
            "poids"=>'poids/exist',
            "note"=>'note/exist'
        ]);
        $request->session()->put('achat_form',$achat);



        return response()->json([
            "status"=>true,
            "data"=>$achat->toJson()
        ]);
    }



    public function hydrateUpdate($request,$achat){

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->session()->has('achat_form')){
            $achat=$request->session()->get("achat_form");
        }
        else{
            $achat=new Achat();
        }

        return view("pages.achat.create",compact('achat'));
    }


    public function save(Request $request,$op,$validationArray,$hydrateArray,$id){
        $validator=Validator::make($request->all(),$validationArray);
        if($validator->fails()){
            return   \Npl\Brique\Http\ResponseAjax\Validation::validate($validator);
        }else{
            DB::beginTransaction();
            try {
                if($id>0){
                    $achat=Achat::find($id);
                }
                else{
                    $achat=new Achat();
                    $achat->somme=0;
                    $achat->poids=0;
                }
                HydrateFacade::make($achat,$request,$hydrateArray);
                if($request->type_montant=="detail" && $request->somme>0){
                    $achat->somme_detail=$request->somme_detail;
                    $achat->somme=$request->somme_detail * $request->poids;
                }
                else{
                    $achat->somme_detail=0;
                }
                DoneByUser::inject($achat);
                $achat->$op();
                $request->session()->forget('achat_form');
                DB::commit();
                return [
                    "status"=>true,
                    "message"=>"Enregistement Achat succes",

                    "id"=>$achat->id,
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response=$this->save($request,"save",[
            'fournisseur'=>"required|exists:contacts,id",
            //'chauffeur'=>"exists:contacts,id",
            'somme'=>[new PositiveRule],
            "poids"=>[new PositiveRule],
            "note"=>"max:255"
        ],[
            "somme"=>"somme/exist",
            "fournisseur_id"=>'fournisseur',
            "chauffeur_id"=>'chauffeur/exist',
            "poids"=>'poids/exist',
            "note"=>'note/exist'
        ],0);

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
        $achat=Achat::find($id);
        return view("pages.achat.voir",compact('achat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $achat=Achat::findOrFail($id);
        return view('pages.achat.create',compact('achat'));

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
        $response=$this->save($request,"save",[
            'fournisseur'=>"required|exists:contacts,id",
            'chauffeur'=>"exists:contacts,id",
            'somme'=>[new PositiveRule],
            "poids"=>[new PositiveRule],
            "note"=>"max:255"
        ],[
            "somme"=>"somme/exist",
            "fournisseur_id"=>'fournisseur/exist',
            "chauffeur_id"=>'chauffeur/exist',
            "poids"=>'poids/exist',
            "note"=>'note/exist'
        ],$id);

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
}
