<?php

namespace App\Http\Controllers\Vente;


use App\Models\Vente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ModelHaut\ContactHaut;
use App\ModelHaut\VenteHaut;
use App\Models\Contact;
use App\Models\LignePaiement;
use Npl\Brique\Http\ResponseAjax\Validation;
use Npl\Brique\Rules\PositiveRule;
use Npl\Brique\Util\DataBases\DoneByUser;

use DB,Validator,DataTables;
use Illuminate\Validation\Rules\Exists;
use Npl\Brique\Http\ResponseAjax\DeleteRow;
use Npl\Brique\Rules\NOp;
use Npl\Brique\Rules\NSelect;
use Npl\Brique\Util\NplFilter;
use App\Util\Access;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class VenteController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('droit:vente_bois,r')->only('index','getData');
        $this->middleware('droit:vente_bois,r')->only('store','create');
        $this->middleware('droit:vente_bois,u')->only('update');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id){

       $vente= Vente::findOrFail($id);

        return view("pages.vente.voir",compact('vente'));
    }
    public function index()
    {

        //
        return view('pages.vente.liste');
    }

    public function print($id){
         $vente= Vente::findOrFail($id);
        return response()->json([
            "status"=>true,
            "html"=>view('pages.vente.print',compact('vente'))->render()
        ]);
            // return view('pages.vente.print',compact('vente'));
    }

     public function printer($id){
         $vente= Vente::findOrFail($id);
         return view('pages.vente.print',compact('vente'));
    }


    public function print_facture($id){
        $vente= Vente::findOrFail($id);
        return view('pages.vente.printFacture',compact('vente'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vente= new Vente;
        $clientid=0;
        return view('pages.vente.create',compact('vente','clientid'));
    }
    public function createWithClient($id)
    {
        $vente= new Vente;
        $clientid=$id;
        return view('pages.vente.create',compact('vente','clientid'));
    }

    public function store(Request $request){
        $response=$this->save($request,$this->memeValidationSave()+[],[],'save');

        return response()->json($response);
    }

    public function edit(Request $request,$id){
        $vente=Vente::where('id',$id)->first();
        $clientid=$id;
        return view("pages.vente.create",compact('vente','clientid'));
    }

    public function update(Request $request,$id){
        $response=$this->save($request,$this->memeValidationSave()+[],[],'update',$id);

        return response()->json($response);
    }

    public function memeValidationSave(){

        $tab=[

            'client'=>'numeric',
            'nom'=>'max:50',
            'telephone'=>'max:50',
            'note'=>'max:255',
            'produits'=>'array',
            'quantite'=>'array',
            'produits.*'=>'exists:bois_produits,id',
            'quantite.*'=>[new PositiveRule],
            'montant'=>[new PositiveRule],
        ];
        return $tab;
    }

    public function save(Request $request,Array $validationArray,$hydrateArray,$dataBaseMethod,$id=0){

        $validator = Validator::make($request->all()+['id'=>$id], $validationArray);
        $validator->after(function($validator)use($request){
            if(isset($request->client) && !empty($request->client)){
                if(!Contact::where('id',$request->client)->where('archiver',0)-> exists()){
                    $validator->errors()->add(
                        'client', "le client est desactivé ou n existe pas"
                    );
                }
            }
            else{
                if(empty($request->nom)){
                    $validator->errors()->add(
                        'nom', "le client ou le nom doit etre rensegné"
                    );
                }
            }
            $ac=Access::canAccess('vente_paye_non_livre',['c']);


        });
        if($validator->fails()){
            return Validation::validate($validator);
        }
        else{
            DB::beginTransaction();
            try {

                $is_new=false;
                if($id){
                    $vente=Vente::where('id',$id)->first();

                }else{
                    $vente=new Vente;
                    $vente->etat=VenteHaut::COMMANDE;
                    $is_new=true;
                    DoneByUser::inject($vente);

                }
                $vente->note=$request->note;
                if($request->client){
                    $vente->contact_id = $request->client;
                }
                else{
                    $vente->nom= $request->nom;
                    $vente->telephone= $request->telephone;
                }
                if($request->has('produits')){
                    DoneByUser::inject($vente);
                }

                $vente->$dataBaseMethod();
                if($request->has('produits')){
                    VenteHaut::updateLigneVentes($vente,$request);
                }
                if($request->has('montant')&&  $is_new && $request->montant > 0){
                    // dd('montant');
                    $this->insererPaiement($vente,$request->montant);

                }

                VenteHaut::updateEtatVente($vente);
                VenteHaut::libererJeton($vente);
                ContactHaut::updateCompte($vente->contact_id);

                if($is_new && $vente->sumRestant()<=0 && !Access::canAccess('vente_paye_non_livre',['c'])){
                    DB::rollback();
                    return [
                        'status'=>false,
                        'message'=>"Vous n'avez pas l'autorisation de creer un depot",
                        'id'=>$vente->id
                    ];
                }

                DB::commit();
                return [
                    'status'=>true,
                    'message'=>'Enregistrement effectué avec success',
                    'id'=>$vente->id
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


    public function insererPaiement($vente,$montant){
        $lignePaiement=new LignePaiement();
        $lignePaiement->vente_id=$vente->id;
        $lignePaiement->somme=$montant;
        DoneByUser::inject($lignePaiement);
        $lignePaiement->save();
    }

    public function returnVentes(Request $request,$filter="tous"){
        $validator = Validator::make($request->all(),[
            'tous'=>'max:100',
            'client'=>[new NOp(NOp::TEXT)],
            'etat'=>[new NSelect()],
            'filter'=>'max:100'
        ]);
        $ventes= Vente::select(DB::raw('ventes.id,ventes.*'))
                 ->orderBy('ventes.updated_at','desc');
        $ventes->leftJoin('contacts', 'ventes.contact_id', '=', 'contacts.id');

        $ventes->where(function($query)use($filter,$request){
            switch($filter){
                case 'all':
                    break;
                case VenteHaut::COMMANDE:
                    $query->where('ventes.etat',VenteHaut::COMMANDE);
                    break;
                case VenteHaut::ACCOMPTE:
                    $query->where('ventes.etat',VenteHaut::ACCOMPTE);
                    break;
                case "paye_non_livre":
                        $query->where('ventes.etat',VenteHaut::PAYE_NON_LIVRE);
                        break;
                default :
                    if(!$request->has('tous') || empty($request->tous))
                        $query->where('ventes.updated_at','>=',now()->format("Y-m-d 00:00"));

            }
        });
        //filter select
        $ventes->where(function($query)use($request){
            NplFilter::select($query,$request,'etat',[
                VenteHaut::COMPLETE=>['ventes.etat','like',VenteHaut::COMPLETE],
                VenteHaut::ACCOMPTE=>['ventes.etat','like',VenteHaut::ACCOMPTE],
                VenteHaut::COMMANDE=>['ventes.etat','like',VenteHaut::COMMANDE],
            ]);
        });

        //filter contact
        $ventes->where(function($query)use($request){
            NplFilter::one($query,$request,'client','contacts.nom','text','where');
            NplFilter::one($query,$request,'client','ventes.nom','','orWhereRaw');

        });

        //date creation
        $ventes->where(function($query)use($request){
            NplFilter::interval($query,$request,'date_creation','ventes.created_at','date');
        });

        if($request->has('tous')){
            $ventes->where(function($query)use($request){
                if(!empty($request->tous)){
                    $request->tous=str_replace('vs-','',$request->tous);
                }
                $query->whereRaw("concat(cast(ventes.id as varchar(49))) like '".$request->tous."%' ");
                $query->orWhere('contacts.nom','like','%'.$request->tous.'%');
                $query->orWhere('ventes.nom','like','%'.$request->tous.'%');
            });
        }
        $message="";
        $status="true";
        if($validator->fails()){
            $ventes=[];
            $message="Les données ne sont pas valides";
            $status=false;
        }
        else{
            $ventes=$ventes->get();
        }
        $somme=$ventes->sum(function($vente){
            return $vente->sumVente();
        });
        $data = DataTables::of($ventes)

            ->addColumn('client',function($vente){
                if($vente->contact_id)
                    return $vente->client->nom;
                else
                    return $vente->nom;
            })
            ->addColumn('montant',function($vente){
                $GLOBALS['somme']=$vente->sumVente();
                return view('npl::components.data-table.child-cell')
                ->with('classStyle',"dt-col dt-min-col-4")
                ->with('style','')
                ->with('slot',number_format($vente->sumVente(),0,',',' ')." FCFA" );

            })
            ->addColumn('montantRestant',function($vente){
                 return view('npl::components.data-table.child-cell')
                ->with('classStyle',"dt-col dt-min-col-4")
                ->with('style','')
                ->with('slot',number_format($vente->sumRestant(),0,',',' ') ." FCFA" );

            })

            ->addColumn('etat',function($vente){
                $coleur="danger";
                switch ($vente->etat) {
                    case VenteHaut::ACCOMPTE:
                        $couleur="badge-danger";
                        break;
                    case VenteHaut::COMMANDE:
                        $couleur="badge-warning";
                        break;
                    case VenteHaut::COMPLETE:
                        $couleur='badge-success';
                        break;
                    case VenteHaut::PAYE_NON_LIVRE:
                            $couleur='badge-primary';
                            break;
                }

                return  view('npl::components.bagde.badge')
                ->with('text',$vente->etat)
                ->with('class',$couleur);
            })

            ->addColumn('numeroVente',function($vente){
                return view('npl::components.links.simple')
                ->with('url',url("vente/".$vente->id))
                ->with('text','VS-'.$vente->id)
                ->with('class','lien-sp dt-col dt-min-col-3');
            })
            ->addColumn('date',function($vente){
                $date=($vente->created_at)?$vente->created_at->format('d-m-Y'):'non defini';
                return view('npl::components.data-table.child-cell')
                ->with('classStyle',"dt-col dt-min-col-4")
                ->with('style','')
                ->with('slot',$date);

            })
            ->addColumn('heure',function($vente){
                return ($vente->created_at)?$vente->created_at->format('H:i:s'):'non defini';
            })
            ->rawColumns(['numeroVente','client','montant','montantRestant','date','heure','etat'])
            ->with('status',$status)
            ->with('message',$message)
            ->with('somme',number_format($somme,0,',',' '))
            ->toJson();

        return $data;


    }


    public function destroyMany(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'vente_select'=>'array|required',
            'vente_select.*'=>['numeric','exists:App\Models\Vente,id']
        ]);

        $validator->after(function($validator)use($request){
            if(Auth::user()->role->nom!="Administration"){
                foreach ($request->vente_select as $key => $value) {
                if(!Vente::where('id',$value)->where('etat',VenteHaut::COMMANDE)->exists()){
                    $validator->errors()->add(
                        'vente_select', "Ce Vente ne peut pas ếtre supprimer par un utilisateur simple"
                    );
                }
            }
            }



        });

        if($validator->fails()){
            return response()->json(Validation::validate($validator));
        }
        else{
            $ventes=Vente::whereIn('id',$request->vente_select)->get();
            return response()->json(DeleteRow::many('ventes',$request->vente_select,'id',function($ids)use($ventes){
                    foreach($ventes as $vente){
                        ContactHaut::updateCompte($vente->contact_id);
                    }
                } ,
                function($ids)use($ventes){
                    foreach($ventes as $vente){
                        foreach($vente->ligne_ventes as $ligneVente){
                            VenteHaut::deleteLigneVente($ligneVente);
                        }

                    }
                }
            ));

        }
    }

    public function preter($id){
         $validator=Validator::make(['id'=>$id],
        [
            'id'=>['numeric','exists:App\Models\Vente,id']
        ]);

        $validator->after(function($validator)use($id){
            $vente= Vente::where('id',$id)->first();
            if(!Access::canAccess('encaissement',['c'])){
                $validator->errors()->add(
                        'id', "Oups! vous n avez pas l'autorisation"
                );
            }
            else{
                if($vente->sumRestant()==0){
                    $validator->errors()->add(
                        'id', "la vente est déja complete"
                    );
                }
            }

            if((!$vente->client) || empty($vente->client->ncni_photo_1) || empty($vente->client->ncni_photo_1) ){
                $validator->errors()->add(
                '   client', "Les photos de la carte du client no=e sont pas rensoignées"
                );

            }

        });

        if($validator->fails()){
            return response()->json(Validation::validate($validator));
        }
        else{
            DB::beginTransaction();
            try {
                $vente= Vente::where('id',$id)->first();
                $vente->etat=VenteHaut::ACCOMPTE;
                $vente->update();
                ContactHaut::updateCompte($vente->contact_id);
                DB::commit();
                return response()->json([
                    'status'=>true,
                    'message'=>"enregistrement reussi"
                ]);
            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json([
                    'status'=>false,
                    'message'=>"Erreur ! veillez reessayer"
                ]);
            }


        }
    }

}
