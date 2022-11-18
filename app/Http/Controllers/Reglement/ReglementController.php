<?php

namespace App\Http\Controllers\Reglement;

use App\Http\Controllers\Controller;
use App\Models\Achat;
use App\Models\Contact;
use App\Models\Reglement;
use App\Service\ReglementService;
use Illuminate\Http\Request;
use Npl\Brique\Http\ResponseAjax\Validation;
use Npl\Brique\Rules\PositiveRule;
use Validator,DataTables,Auth,DB;

class ReglementController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('droit:reglement_validation,c')->only('valider');
        $this->middleware('droit:contact,c')->only('store','create');
        $this->middleware('droit:contact,u')->only('update','archiverMany','desarchiverMany','archiver','desarchiver','destroy');

    }

    public function getData(Request $request,$filter="tous"){
        $validator = Validator::make($request->all(),[
            'tous'=>'max:100',
            'filter'=>'max:100'
        ]);
        $fournisseurs= Contact::where('is_fournisseur','>',0);


        if($request->has('tous')){
            $fournisseurs->where(function($query)use($request){
                $query->orWhere('nom','like','%'.$request->tous.'%');
            });
        }
        $message="";
        $status="true";
        if($validator->fails()){
            $fournisseurs=[];
            $message="Les données ne sont pas valides";
            $status=false;
        }
        else{
            $fournisseurs=$fournisseurs->get();
        }

        $data = DataTables::of($fournisseurs)
            ->addColumn('nom_f',function($fournisseur){
                return view('npl::components.links.simple')
                ->with('url',url("reglement/fournisseur/".$fournisseur->id))
                ->with('text',ucfirst($fournisseur->nom))
                ->with('class','lien-sp dt-col dt-min-col-4');
            })
            ->addColumn('compte_f',function($fournisseur){
                $reglement=ReglementService::lastReglement($fournisseur->id);
                if($reglement){
                    $somme=$reglement->total();
                    if($somme>0) $cl='badge-success';
                    elseif($somme<0) $cl='badge-danger';
                    else $cl='badge-primary';
                }
                else{
                    $cl="badge-primary";
                    $somme=0;
                }

                return view('npl::components.data-table.child-cell')
                ->with('classStyle',"dt-col dt-min-col-3")
                ->with('style','')
                ->with('slot',number_format($somme,0,',',' ')
                    .view('npl::components.bagde.badge')
                    ->with('text','FCFA')
                    ->with('class','ml-2 '.$cl)
                  );
                ;
                         ;
            })
            ->addColumn('action',function($fournisseur){
                $view=view('npl::components.links.simple')
                ->with('url',url("reglement/lastchargementfournisseur/".$fournisseur->id))
                ->with('text','')
                ->with('icon','last_page')
                ->with('class','btn btn-sm btn-outline-warning')
                .view('npl::components.links.simple')
                ->with('url',url("reglement/fournisseur/".$fournisseur->id."/list"))
                ->with('text','')
                ->with('icon','history')
                ->with('class','ml-2 btn btn-sm btn-outline-success ');
                return view('npl::components.data-table.child-cell')
                ->with('classStyle',"dt-col dt-min-col-3")
                ->with('style','')
                ->with('slot',$view);
            })

            ->addColumn('date',function($fournisseur){
                $date =($fournisseur->created_at)?$fournisseur->created_at->format('d-m-Y'):'non defini';
                return view('npl::components.data-table.child-cell')
                ->with('classStyle',"dt-col dt-min-col-3")
                ->with('style','')
                ->with('slot',$date);
            })
            ->rawColumns(['nom_f','compte_f','date','action'])
            ->with('status',$status)
            ->with('message',$message)
            ->toJson();

        return $data;


    }

    public function valider(Request $request,$id){
        $reglement=Reglement::find($id);
        $message="";
        $status=true;
        $id=0;
        if(!$reglement){
            $status=false;
            $message="le reglement n'existe pas";
        }
        else{
            if($reglement->etat!=0){
                $status=false;
                $message="le reglement est deja fermé";
            }
            else{
                if(Auth::user()->role->nom!="Administration"){
                    $status=false;
                    $message="Vous n'avez pas l'aurorisation de régler le reglement";
                }
                else{
                    $status=true;
                    $message="Enregistrement reussie";
                    $reglement->etat=1;
                    $reglement->last=$reglement->total();
                    $reglement->update();
                    $newreglement=ReglementService::newReglement($reglement->fournisseur_id);
                    $id=$newreglement->id;

                }
            }

        }


        return response()->json([
            'status'=>$status,
            'message'=>$message,
            'id'=>$id
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.reglement.liste');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function lastAchat($id){
        try {
            $reglement=Reglement::findOrFail($id);
            $achat=Achat::where('reglement_id',$reglement->id)
                        ->orderBy('created_at','desc')->first();
            if($achat) $status=true; else $status=false;

            return response()->json([
                'status'=>$status,
                'id'=>$achat->id,
                'message'=>'lien trouvé'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>'Ce reglement ne contient pas de chargement'
            ]);
        }

    }
    public function redirectLasReglement($fournisseurId){
        $fournisseur=Contact::where('is_fournisseur','>',0)
                              ->where('id',$fournisseurId)
                              ->first();
                          //    dd($fournisseur);
        if(!$fournisseur){
            return redirect('404');
        }
        $reglement=ReglementService::lastReglement($fournisseur->id);
        if(!$reglement){
            $reglement=ReglementService::newReglement($fournisseur->id);
            $reglement->save();
        }
        return redirect('reglement/'.$reglement->id);
    }

    public function show($id)
    {
        $reglement=Reglement::FindOrFail($id);
        return view('pages.reglement.voir',compact('reglement'));
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
        //
    }

    public function editInitial(Request $request,$id){

        $validator=Validator::make($request->all()+['id',$id],[
            'somme'=>['required','numeric'],
            'id'=>'exists:reglements,id'
        ]);
        if($validator->fails()){
            return Validation::validate($validator);
        }
        DB::beginTransaction();
        try {
            $reglement=Reglement::find($id);
            $reglement->initial=$request->somme;
            $reglement->update();
            DB::commit();
            return response()->json([
                    'status'=>true,
                    'message'=>'Enregistrement effectué avec success',
                    'id'=>$reglement->id,
                    'initial'=>number_format($reglement->initial,0,',',' ').' FCFA',
                    'total_paiement'=>number_format($reglement->totalSomme(),0,',',' '),
                    'total_achat'=>number_format($reglement->totalAchat(),0,',',' '),
                    'last'=>number_format($reglement->total(),0,',',' ').' FCFA',
                ]
            );
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
