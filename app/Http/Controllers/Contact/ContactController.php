<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Telephone;
use App\Models\ContactPrix;
use App\Models\Vente;
use Illuminate\Validation\Rule;

use DB,DataTables,Validator;
use Npl\Brique\Http\ResponseAjax\DeleteRow;
use Npl\Brique\Http\ResponseAjax\Validation;
use Npl\Brique\Rules\DataBase\TelephoneRule;
use Npl\Brique\Util\DataBases\DoneByUser;

use Npl\Brique\Rules\DbDependance;
use Npl\Brique\Rules\Ninterval;
use Npl\Brique\Rules\NOp;
use Npl\Brique\Rules\NSelect;
use Npl\Brique\Util\Controller\ArchiverTrait;
use Npl\Brique\Util\HydrateFacade;
use Npl\Brique\Util\ImageFactory;
use Npl\Brique\Util\NplFilter;
use Npl\Brique\Util\NplStringFormat;
use Npl\Brique\Rules\PositiveRule;


class ContactController extends Controller
{
    use ArchiverTrait;

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('droit:contact,r')->only('index','getData');
        $this->middleware('droit:contact,c')->only('store','create');
        $this->middleware('droit:contact,u')->only('update','archiverMany','desarchiverMany','archiver','desarchiver','destroy');

    }

    public function getInfos(){
        return [
            'model'=>'Contact'
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
            $contacts=Contact::select(DB::raw('distinct contacts.id,contacts.*'));
            $contacts->leftJoin('telephones', 'contacts.id', '=', 'telephones.contact_id');
            $contacts->where(function($query)use($filter){

                switch($filter){
                    case 'archiver':
                        $query->where('contacts.archiver',1);
                        break;
                    case 'client':
                            $query->where('contacts.is_ client',1);
                            break;
                    case 'client_dette':
                            $query->where('contacts.is_client',1);
                            $query->where('contacts.compte','<',0);
                            break;
                    case 'client_credit':
                            $query->where('contacts.is_client',1);
                            $query->where('contacts.compte','>',0);
                            break;
                    case 'fournisseur':
                            $query->where('contacts.is_fournisseur',1);
                            break;
                    case 'fournisseur_dette':
                                $query->where('contacts.is_fournisseur',1);
                                $query->where('contacts.compte','<',0);
                                break;
                    case 'fournisseur_credit':
                                $query->where('contacts.is_fournisseur',1);
                                $query->where('contacts.compte','>',0);
                                break;
                    default :
                        $query->where('contacts.archiver',0);
                }
                if($filter!='archiver' && !empty($filter)){
                    $query->where('contacts.archiver',0);
                }
            });
            // filter telephone
            $contacts->where(function($query)use($request){
                NplFilter::one($query,$request,'tel','telephones.numero','number');
                NplFilter::one($query,$request,'tel','telephones.indicatif','number','orWhereRaw');

            });

            // filter mail
            NplFilter::one($contacts,$request,'email','contacts.email','text','Where');
            // filter fonction
            NplFilter::one($contacts,$request,'fonction','contacts.fonction','text','Where');

             //filter select type
            $contacts->where(function($query)use($request){
                NplFilter::select($query,$request,'type_contact',[
                    'client'=>['contacts.is_client','=','1'],
                    'fournisseur'=>['contacts.is_fournisseur','=','1'],
                ]);
            });

             //filter date creation
             $contacts->where(function($query)use($request){
                NplFilter::interval($query,$request,'date_creation','contacts.created_at','date');
            });

            if($request->has('tous') && !empty($request->tous)){
                $contacts->where('contacts.nom','like','%'.$request->tous.'%');
            }

            $message="";
            $status="true";
            if($validator->fails()){
                $contacts=[];
                $message="Les données ne sont pas valides";
                $status=false;
            }
            else{
                $contacts=$contacts->distinct('contacts.id')->get();
            }


        return DataTables::of($contacts)
                ->addColumn('fonctions',function($contact){
                    $attributes="";
                    $tab=['is_client'=>['client','badge-success'],'is_fournisseur'=>['fournisseur','badge-warning']];
                    foreach ($tab as $key => $value) {
                        if($contact->$key==1){
                            $attributes.= view('npl::components.bagde.badge')
                            ->with('text',$value[0])
                            ->with('class',''.$value[1]);
                        }
                    }
                    if(!empty($contact->fonction)){
                        $attributes.= view('npl::components.bagde.badge')
                            ->with('text',$contact->fonction)
                            ->with('class','badge-danger');
                    }
                    return $attributes;
                })
                ->addColumn('compte_f',function($contact){
                    if($contact->compte)
                        return view('npl::components.bagde.simple')
                        ->with('classStyle','bg-danger').' '.
                        number_format($contact->compte,0,'.',' ').' FCFA';
                    else
                        return view('npl::components.bagde.simple')
                        ->with('classStyle','bg-success').' libre';
                })
                ->addColumn("nom",function($contact){
                    return view('npl::components.links.simple')
                    ->with('src',asset("images/contacts/".$contact->photo))
                    ->with('url',url("contact/".$contact->id))
                    ->with('text',$contact->nom)
                    ->with('class','lien-sp');
                })
                ->addColumn('tel',function($contact){
                    $telephones= Telephone::where('contact_id',$contact->id)->get();
                    $text="";
                    if(count($telephones)){
                        foreach ($telephones as $key => $value) {
                            if($value->numero){
                                if($key!=0){
                                    $text .=' / ';
                                }
                                $text .= NplStringFormat::telephone($value->numero.'',$value->indicatif.'');
                            }
                        }
                        return (!empty($text))?$text:'Aucun';
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
                ->addColumn("type",function($contact){
                    if($contact->is_client==1)
                        return 'Client';
                    if($contact->is_fournisseur==1)
                        return 'Fournisseur';
                    return 'Simple';
                })
                ->rawColumns(['nom','tel','compte_f','fonctions','created_at_f','updated_at_f','type'])
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
        $contacts=Contact::all();
        return view("pages.contact.liste",compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contact=new Contact;
        $vente=null;
        return view("pages.contact.create",compact('contact','vente'));
    }

    public function createWith(Request $resuest,$vente_id,$nom,$tel="")
    {
        $vente=Vente::findOrFail($vente_id);
        $contact=new Contact;
        $contact->nom=$nom;
        $tele=new Telephone;
        $tele->numero=$tel;
        $contact->telephones->add($tele);
        return view("pages.contact.create",compact('contact','vente'));
    }

    public function saveContactPrix($request,$contact){
        if($request->has('bois')){
            if(count($request->bois)>0){
                for ($i=0; $i < count($request->bois) ; $i++) {
                    $op='update';
                    $contact_prix=ContactPrix::where('bois_id',$request->bois)->where('contact_id',$contact->id)->first();
                    if(!$contact_prix){
                        $contact_prix=new ContactPrix;
                        $op='save';
                    }
                    $contact_prix->bois_id=$request->bois[$i];
                    $contact_prix->prix_vente=$request->prix_vente[$i];
                    $contact_prix->prix_achat=$request->prix_achat[$i];
                    $contact_prix->contact_id=$contact->id;
                    DoneByUser::inject($contact_prix);
                    $contact_prix->$op();
                }
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
        $response=$this->save($request,$this->memeValidationSave()+[
            "nom"=>"required|max:100|unique:contacts,nom",
        ],
            ['nom','email','ncni','fonction','adresse'],
            'save'
        );

        return response()->json($response);

    }

    public function save(Request $request,Array $validationArray,$hydrateArray,$dataBaseMethod,$id=0){

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
                $contact=new Contact;
                if($id>0){
                    $contact=Contact::where('id',$id)->first();
                }
                HydrateFacade::make($contact,$request,$hydrateArray);


                if($request->has('client_fournisseur')){
                    $contact->is_client=(in_array('client',$request->client_fournisseur))?true:false;
                    $contact->is_fournisseur=(in_array('fournisseur',$request->client_fournisseur))?true:false;
                }

                ImageFactory::store($request,$contact,'photo','images/contacts',$contact->id);
                ImageFactory::store($request,$contact,'ncni_photo_1','images/contacts',$contact->id.'cni1');
                ImageFactory::store($request,$contact,'ncni_photo_2','images/contacts',$contact->id.'cni2');
                $contact->$dataBaseMethod();

                //save prix
                $this->saveContactPrix($request,$contact);

                //save telephone
                $this->saveTelephone($request,'tel1',$contact->id);
                if($request->has('tel2_numero') && !empty($request->tel2_numero.''))
                    $this->saveTelephone($request,'tel2',$contact->id);

                if($request->has('vente_id')){
                    $vente=Vente::find($request->vente_id);
                    $vente->contact_id=$contact->id;
                    $vente->update();
                }

                DB::commit();

                return [
                    'status'=>true,
                    'message'=>'Enregistrement effectué avec success',
                    'id'=>$contact->id
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

    public function saveTelephone(Request $request,$attribute,$idContact){
        $telephone=new Telephone;
        $att=$attribute.'_id';
        if($request->has($att)){
            $telephone=Telephone::where('id',$request->$att)->first();
        }
        $telephone->contact_id=$idContact;


        $att=$attribute.'_indicatif';
        $telephone->indicatif=$request->$att;
        $att=$attribute.'_numero';
        $telephone->numero=$request->$att;

        $att=$attribute.'_id';
        if($request->has($att)){

            $telephone->update();
        }
        else{
            $telephone->save();
        }


        return $telephone;

    }


    public function memeValidationSave(){

        $tab=[

            "tel1"=>[new TelephoneRule()],
            "tel2"=>[new TelephoneRule()],
            "photo"=>"image",
            "ncni_photo_2"=>"image",
            "ncni_photo_1"=>"image",
            "fonction"=>"max:255",
            "adresse"=>"max:150",
            'ncni'=>'max:50',
            'client_fournisseur'=> 'array',
            'bois'=>'array',
            'bois.*'=>'exists:bois,id',
            'prix_vente'=>'array',
            'prix_vente.*'=>[new PositiveRule],
            'prix_achat'=>'array',
            'prix_achat.*'=>[new PositiveRule],
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
        $contact= Contact::where('id',$id)->first();
        return view("pages.contact.voir",compact('contact'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact= Contact::where('id',$id)->first();
        $vente=null;
        return view("pages.contact.create",compact('contact','vente'));
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
        $request->request->add(['id'=>$id]);
        $response=$this->save($request,$this->memeValidationSave()+[
            'id'=>"required|exists:App\Models\Contact,id",
            'nom'=>['required',Rule::unique('contacts','nom')->ignore($id)]
        ],
            ['nom','email','ncni','fonction','adresse'],
            'update',$id
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
            'contact_select'=>'array|required',
            'contact_select.*'=>['numeric',new DbDependance('ventes','contact_id',[])],
        ]);

        if($validator->fails()){
            return response()->json(Validation::validate($validator));
        }
        else{
            return response()->json(DeleteRow::many('contacts',$request->contact_select));

        }
    }





}
