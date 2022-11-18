<?php

namespace App\Http\Controllers\Reglement;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;

use App\Models\Achat;
use App\Models\LigneReglement;
use App\Models\Reglement;
use App\Util\Access;
use Illuminate\Http\Request;

use DataTables;

class LigneReglementController extends Controller
{
    public function getData($id){
        $reglement=Reglement::FindOrFail($id);
        $lignes=LigneReglement::where('reglement_id',$id)->get();
        $achats=Achat::where('reglement_id',$id)->get();
        foreach($achats as $achat){
            $lignes->push($achat);
        }
        $lignes=$lignes->sortByDesc('created_at');
        $status=true;
        $message='';
        // dd($lignes);
        return DataTables::of($lignes)
        ->addColumn('description',function($ligne) use($reglement){

            if($ligne instanceof Achat){
                $cl=($ligne->somme > 0)?'text-primary':'text-danger';
                $etat=($ligne->somme > 0)?'Complete':'Imcomplete';

                return view('npl::components.links.simple')
                ->with('url',url("achat/".$ligne->id))
                ->with('text',"Achat ".$etat.' : '.$ligne->poids.' Kg')
                ->with('icon','')
                ->with('class','lien-sp  dt-col dt-min-col-5 '.$cl);
            }
            else{
                return $ligne->transaction->description;
            }
        })
        ->addColumn('montant',function($ligne){

            if($ligne instanceof Achat){

                $cl='badge-danger';
                $somme=-    $ligne->somme;
            }
            else {
                $cl='badge-success';
                $somme=$ligne->transaction->somme*(-1);
                $ligne->somme=$somme;

            }
            return view('npl::components.data-table.child-cell')
            ->with('classStyle',"dt-col dt-min-col-3")
            ->with('style','')
            ->with('slot',number_format($somme,0,',',' ')
                .view('npl::components.bagde.badge')
                ->with('text','FCFA')
                ->with('class','ml-2 '.$cl)
              );
        })
        ->addColumn('action',function($ligne) use($reglement){
            if($reglement->etat<=0){
                if($ligne instanceof Achat){
                        $views="<div class=' cache-cache' style='min-width:120px;width:120px;' >"
                        ."<span class='cache-cache-visible'><i class='material-icons'>more_vert</i></span>"
                        ."<div class='cache-cache-invisible ml-3'  >";
                        if(Access::canAccess('reglement_achat',['u']))
                        {
                            $views.= view('npl::components.links.simple')
                            ->with('url',url('achat/'.$ligne->id.'/edit'))
                            ->with('text','')
                            ->with('icon','edit')
                            ->with('class','btn btn-sm btn-outline-warning');
                        }
                        if(Access::canAccess('reglement_achat',['d']))
                        {
                            $views.= '<button class="ml-2 btn btn-sm btn-outline-danger btn-delete-achat" data-id="'.$ligne->id.'">'
                            .'<i class="material-icons md-14">delete</i>'
                        .'</button>';
                        }
                        $views.="</div></div>";
                        return $views;
                    }
                    else{
                        $views="<div class=' cache-cache' style='min-width:120px;width:120px;' >"
                        ."<span class='cache-cache-visible'><i class='material-icons'>more_vert</i></span>"
                        ."<div class='cache-cache-invisible ml-3'  >";
                        if(Access::canAccess('reglement_achat',['u']))
                        {
                            $views.= '<button class="btn btn-sm btn-outline-warning text-black btn-edit-paiement" data-id="'.$ligne->id.'" data-somme="'.$ligne->somme.'">'
                                    .'<i class="material-icons md-14">edit</i>'
                                .'</button>';
                        }
                        if(Access::canAccess('reglement_achat',['d']))
                        {
                            $views.= '<button class="btn-delete-paiement ml-2 btn btn-sm btn-outline-danger" data-id="'.$ligne->id.'">'
                            .'<i class="material-icons md-14">delete</i>'
                        .'</button>';
                        }
                        $views.="</div></div>";
                        return $views;
                    }
            }

        })
        ->addColumn('date',function($fournisseur){
            $date=($fournisseur->created_at)?$fournisseur->created_at->format('d-m-Y h:i'):'non defini';
            return view('npl::components.data-table.child-cell')
            ->with('classStyle',"dt-col dt-min-col-3")
            ->with('style','')
            ->with('slot',$date);
        })
        ->rawColumns(['description','montant','date','action'])
        ->with('status',$status)
        ->with('message',$message)
        ->toJson();
    }

    public function trier($collection){

    }



}
