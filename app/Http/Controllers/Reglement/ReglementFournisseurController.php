<?php

namespace App\Http\Controllers\Reglement;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Reglement;
use App\Service\ReglementService;
use Illuminate\Http\Request;

use Validator,DataTables,DB;

class ReglementFournisseurController extends Controller
{
    public function getData(Request $request,$id,$filter="tous"){
        $validator = Validator::make($request->all(),[
            'tous'=>'max:100',
            'filter'=>'max:100'
        ]);
        $reglements= Reglement::where('fournisseur_id',$id)
                                ->orderBy('created_at','desc');


        $message="";
        $status="true";
        if($validator->fails()){
            $reglements=[];
            $message="Les données ne sont pas valides";
            $status=false;
        }
        else{
            $reglements=$reglements->get();
        }

        $data = DataTables::of($reglements)
            ->addColumn('nom_f',function($reglement){
                return view('npl::components.links.simple')
                ->with('url',url("reglement/".$reglement->id))
                ->with('text','RS-'.ucfirst($reglement->id))
                ->with('class','lien-sp');
            })
            ->addColumn('initial_f',function($reglement){
                if($reglement->initial>0) $cl='badge-success';
                elseif($reglement->initial<0) $cl='badge-danger';
                else $cl='badge-primary';
                return view('npl::components.bagde.badge')
                       ->with('text','FCFA')
                       ->with('class','mr-2 '.$cl)
                       .number_format($reglement->initial,0,',',' ');
                         ;
            })
            ->addColumn('last_f',function($reglement){
                $last=($reglement->etat)? $reglement->last : $reglement->total();
                if($last>0) $cl='badge-success';
                elseif($last<0) $cl='badge-danger';
                else $cl='badge-primary';
                return
                       view('npl::components.bagde.badge')
                       ->with('text','FCFA')
                       ->with('class','mr-2 '.$cl)
                       .number_format($last,0,',',' ');
                         ;
            })
            ->addColumn('etat_f',function($reglement){
                if($reglement->etat){
                    return view('npl::components.bagde.badge')
                    ->with('text','Reglé')
                    ->with('class','badge-success ');;
                }
                else{
                    return view('npl::components.bagde.badge')
                       ->with('text','En cours')
                       ->with('class','badge-warning ');
                }
            })

            ->addColumn('date',function($reglement){
                return ($reglement->created_at)?$reglement->created_at->format('d-m-Y'):'non defini';
            })
            ->rawColumns(['nom_f','initial_f','last_f','etat_f','date'])
            ->with('status',$status)
            ->with('message',$message)
            ->toJson();

        return $data;
    }

    public function show($id){
        $fournisseur=Contact::FindOrFail($id);
        $lastReglement=ReglementService::lastReglement($fournisseur->id);
        return view('pages.reglement.list-fournisseur',compact('fournisseur','lastReglement'));
    }
}
