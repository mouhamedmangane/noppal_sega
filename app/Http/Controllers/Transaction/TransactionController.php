<?php

namespace App\Http\Controllers\transaction;

use App\Http\Controllers\Controller;
use App\Models\LignePaiement;
use App\Models\LigneVente;
use Illuminate\Http\Request;
use App\Models\Transaction;

use App\Models\Vente;

use DB,DataTables,Validator;
use Egulias\EmailValidator\Warning\Warning;
use Npl\Brique\Http\ResponseAjax\DeleteRow;
use Npl\Brique\Http\ResponseAjax\Validation;
use Npl\Brique\Util\DataBases\DoneByUser;

use Npl\Brique\Rules\DbDependance;
use Npl\Brique\Rules\Ninterval;
use Npl\Brique\Rules\NOp;
use Npl\Brique\Rules\NSelect;
use Npl\Brique\Util\HydrateFacade;
use Npl\Brique\Util\NplFilter;
use Npl\Brique\Rules\PositiveRule;
use Npl\Brique\Util\Controller\ArchiverTrait;

class TransactionController extends Controller
{
    use ArchiverTrait;

    public function __construct(){
        $this->middleware('auth');
        // $this->middleware('droit:transaction,r')->only('index','getData');
        // $this->middleware('droit:transaction,c')->only('store','create');
        // $this->middleware('droit:transaction,u')->only('update','archiverMany','desarchiverMany','archiver','desarchiver','destroy');

    }

    public function getInfos(){
        return [
            'model'=>'transaction'
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
            $transactions=Transaction::select(DB::raw('distinct transactions.id,transactions.*'))
                                      ->orderBy('created_at','desc');
            $transactions->where(function($query)use($filter,$request){

                switch($filter){
                    case "all":break;
                    case 'today':
                        $query->where('transactions.created_at','>=',now()->format("Y-m-d 00:00"));
                        break;
                    case 'quinze':
                        $query->where('transactions.created_at','>=',date("Y-m-d 00:00",strtotime('-15 day',time())));
                        break;
                    default :
                        if(!$request->has('tous') || empty($request->tous)){
                            $query->whereMonth('transactions.created_at',now()->format('m'));
                            $query->whereYear('transactions.created_at',now()->format('Y'));
                        }



                }

            });

            $transactions->where(function($query)use($request){
                NplFilter::interval($query,$request,'somme','transactions.somme');
            });
             //filter date creation
             $transactions->where(function($query)use($request){
                NplFilter::interval($query,$request,'date_creation','transactions.created_at','date');
            });

            if($request->has('tous') && !empty($request->tous)){
                if(!empty($request->tous)){
                    $request->tous=str_replace('TR-','',$request->tous);
                }
                $transactions->whereRaw("concat(cast(transactions.id as varchar(49))) like '".$request->tous."%' ");
                $transactions->orWhere('transactions.id','like','%'.$request->tous.'%');
                $transactions->orwhere('transactions.description','like','%'.$request->tous.'%');
                $transactions->orWhere('contacts.nom','like','%'.$request->tous.'%');
                $transactions->orWhere('transactions.type_depense_id','like','%'.$request->tous.'%');
            }

            $message="";
            $status="true";
            if($validator->fails()){
                $transactions=[];
                $message="Les données ne sont pas valides";
                $status=false;
            }
            else{
                $transactions=$transactions->distinct('transactions.id')->get();
            }


        return DataTables::of($transactions)
                ->addColumn("numero",function($transaction){
                    return view('npl::components.links.simple')
                            ->with('url',url($transaction->getUrl()))
                            ->with('text','TR-'.$transaction->id)
                            ->with('class','lien-sp');
                })
                ->addColumn('somme_f',function($transaction){
                    $badge= ($transaction->somme>0)?"badge-success":"badge-danger";
                    return view('npl::components.bagde.badge')
                    ->with('text',number_format($transaction->somme,0,","," ")."FCFA")
                    ->with('class',$badge);
                })
                ->addColumn("description",function($transaction){

                        return $transaction->description;
                })
                ->addColumn("type_depense_f",function($transaction){
                    if($transaction->type){
                        switch ($transaction->type) {
                            case 'AS':
                                $valeur="PAIEMENT FOURNISSEUR";
                                $badge="warning";

                                break;
                            case 'VS':
                               $valeur="ENCAISSEMENT VENTE";
                                $badge="success";
                                break;


                            default:
                                $valeur='';
                                $badge='success';
                                break;
                        }
                        return view('npl::components.bagde.badge')
                        ->with('text',$valeur)
                        ->with('class','badge-  '.$badge);
                    }
                    else{
                        return $transaction->type_depense_id;
                    }

                })
                ->addColumn('note',function($transaction){
                    if($transaction->note){
                        return $transaction->note;
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
        $transactions=Transaction::all();
        return view("pages.transaction.liste",compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $transaction=new transaction;
        $vente=null;
        return view("pages.transaction.create",compact('transaction','vente'));
    }

    public function saveLigneVenteTransaction(){
        $ligne_paiements= LignePaiement::all();
        if($ligne_paiements){

            try {
                DB::beginTransaction();
                foreach ($ligne_paiements as $ligne_paiement) {
                    //id desciption somme typedepense not updat done byuser type, url,created_at
                    if($ligne_paiement->transaction_id==NULL){

                        $ligne_paiement->create_transaction();
                        // $transaction= new Transaction();
                        // $transaction->somme=$ligne_paiement->somme;
                        // $transaction->description=$ligne_paiement->description();
                        // $transaction->done_by_user=1;


                        // if($transaction->save()){
                        //     $ligne_paiement->transaction_id=$transaction->id;
                        //     $ligne_paiement->save();
                        // }
                    }
                 }
                DB::commit();
                return "yes";
            } catch (\Throwable $th) {
                DB::rollback();
                return "non".$th->getMessage();
            }

        }
        return 'aucun ligne dans la table ligne paiement';
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
            DB::begintransaction();

            try {
                $transaction=new Transaction();
                $dataBaseMethod='save';
                if($id>0){
                    $transaction=Transaction::where('id',$id)->first();
                    $dataBaseMethod='update';

                }

                if($request->e_s==1){
                    $transaction->somme=$request->somme;
                    $transaction->type_depense_id=NULL;
                }
                else{
                    $transaction->somme= ($request->somme) * -1;
                    $transaction->type_depense_id=$request->type_depense;
                }
                $transaction->note=$request->note;
                $transaction->description=$request->description;
               // $transaction->somme=$request->somme;

                DoneByUser::inject($transaction);
                $transaction->$dataBaseMethod();

                DB::commit();

                return [
                    'status'=>true,
                    'message'=>'Enregistrement effectué avec success',
                    'id'=>$transaction->id
                ];
            } catch (\throwable $th) {
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
            "description"=>"max:200",
            "note"=>"max:150",
            'somme'=>'required',
            'e_s'=>'required'
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
        $transaction= transaction::where('id',$id)->first();
        return view("pages.transaction.voir",compact('transaction'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaction= transaction::where('id',$id)->first();
        $vente=null;
        return view("pages.transaction.create",compact('transaction','vente'));
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
            'transaction_select'=>'array|required',
            'transaction_select.*'=>['numeric',new DbDependance('ligne_achat_p_s','transaction_id',[])],
        ]);

        if($validator->fails()){
            return response()->json(Validation::validate($validator));
        }
        else{
            return response()->json(DeleteRow::many('transactions',$request->transaction_select));

        }
    }



}
