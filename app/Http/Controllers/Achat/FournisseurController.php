<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;
use App\Models\Achat;
use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Npl\Brique\Util\NplFilter;
use DataTables;
use Illuminate\Support\Facades\DB;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request){
        $validator = Validator::make($request->all(),[
            
        ]);
        $fournisseurs= DB::table('achats')
                    ->leftJoin('ligne_achat_p_s','achats.id','=','ligne_achat_p_s.achat_id')
                    ->leftJoin('depenses','ligne_achat_p_s.depense_id','=','depenses.id')
                    ->join('contacts','achats.fournisseur_id','=','contacts.id')
                    ->select('achats.fournisseur_id as f_id','contacts.nom as fournisseur',
                            DB::raw('SUM(achats.somme) as somme_total'),
                            DB::raw('SUM(poids) as poids_total'),
                            DB::raw('COUNT(achats.id) as nbre_achats'),
                            DB::raw('SUM(depenses.somme) as somme_payer'),
                            DB::raw('MAX(achats.created_at) as last_date'),
                    )
                    ->groupBy('achats.fournisseur_id','contacts.nom');
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
        // $somme=$achats->sum(function($achat){
        //     return $achat->sumAchat();
        // });
         //Fournisseur-NB achat en_cours,Pois somme restante, somme total, last_date
        
        $data = DataTables::of($fournisseurs)
            //'fournisseur','nombre_achat','somme_restante','somme_total','poids_total','last_date'
            ->addColumn('fournisseur',function($fournisseur){
                if($fournisseur->fournisseur){
                    //return $fournisseur->fournisseur;
                    return view('npl::components.links.simple')->with('url',url("fournisseur/".$fournisseur->f_id))
                    ->with('text',$fournisseur->fournisseur)
                    ->with('class','lien-sp');
                    
                }
                return "Aucun";
            }) 
            ->addColumn('nombre_achat',function($fournisseur){
                if($fournisseur->nbre_achats){
                    return $fournisseur->nbre_achats;
                }
                return "Aucun";
            })
            ->addColumn('somme_restante',function($fournisseur){
                return number_format($fournisseur->somme_total-$fournisseur->somme_payer,0,',',' ')." FCFA" ;
            })
            ->addColumn('somme_total',function($fournisseur){
                return number_format($fournisseur->somme_total,0,',',' ')." FCFA" ;
            })
            ->addColumn('poids_total',function($fournisseur){
                return number_format($fournisseur->poids_total,0,',',' ') ." KG" ;
            })
            ->addColumn('last_date',function($fournisseur){
                return ($fournisseur->last_date);
            })

            ->rawColumns(['fournisseur','nombre_achat','somme_restante','somme_total','poids_total','last_date'])
            ->with('status',$status)
            ->with('message',$message)
            ->toJson();

        return $data;


    }

    public function index()
    {
        //
        return view('pages.fournisseur.liste');
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
    public function show($id)
    {
        //
        $depense= Depense::where('id',3)->first();
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
}
