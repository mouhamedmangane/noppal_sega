<?php

namespace App\Http\Controllers;

use App\ModelHaut\Tronc;
use App\ModelHaut\VenteHaut;
use App\Models\Caisse;
use App\Models\Depense;
use App\Models\LignePaiement;
use App\Models\LigneVente;
use App\Models\Transaction;
use Carbon\Carbon;

use App\Models\Vente;
use DateTime;
use Illuminate\Http\Request;
use DB,DataTables;

class HomeController extends Controller
{
    //public function index(Request $request,$date="today"){//voir sur les dates

    public function index(Request $request,$date="today"){
        if($date=="today"){
            $date=now()->format("Y-m-d 00:00");
        }
        else{
            $date.=" 00:00";
        }


        $vjj=0;
        $ventes=Vente::where("created_at",'>=',$date)->get();

        $dette= Vente::where("etat",'commande')->get();
        $d=0;//dette
        $nbre_accompte=0;
        $nbre_tronc=0;
        if($dette){
            foreach ($dette as $dt) {
                $d+=$dt->sumRestant();
                $nbre_accompte++;
            }
        }
        if($ventes){
            foreach ($ventes as $vente) {
              $vjj+=$vente->sumPayement();
              foreach($vente->ligne_ventes as $lv){
                if($lv->bois_produit->discriminant=="tronc")
                    $nbre_tronc++;
              }
            }
        }
        $datetime=new DateTime($date);

        $month=$datetime->format('m');
        $year=$datetime->format('Y');


        $totalVenteJour=$this->totalVenteJour($date);
        $totalVenteMois=$this->totalVenteMois($month,$year);


        $donnees=[];
        $donnees['nbre_accompte']=Vente::where('etat',VenteHaut::ACCOMPTE)->count();
        $donnees['caisse_jour']=(isset($totalVenteJour->montant))?
                                number_format($totalVenteJour->montant,0,',',' '):0;
        $donnees['nbre_tronc']=(isset($totalVenteJour->quantite))?
                                number_format($totalVenteJour->quantite,0,',',' '):0;
        $donnees['caisse_mois']=(isset($totalVenteMois->montant))?
                                number_format($totalVenteMois->montant,0,',',' '):0;
        $donnees['nbre_tronc_mois']=(isset($totalVenteMois->quantite))?
                                number_format($totalVenteMois->quantite,0,',',' '):0;

        $donnees['paye_non_livre']=number_format($this->totalPayeNonLivre($date),0,',',' ');
        $donnees['paye_non_livre_jour']=number_format($this->totalPayeNonLivreJour($date),0,',',' ');
        $donnees['etat_caisse']=number_format($this->etat_caisse(),0,',',' ');


        $donnees['dette']=number_format($this->totalDette(),0,',',' ').' / '.$donnees['nbre_accompte'];

        $donnees['total_encaisse']= number_format($this->totalEncaisseJour($date),0,',',' ');

        $donnees['depense_jour']= number_format($this->totalDepenseJour($date),0,',',' ');
        $donnees['depense_mois']= number_format($this->totalDepenseMois($month,$year),0,',',' ');

        $donnees['depense_annee']=number_format($this->totalDepenseAnnee($year),0,',',' ');
        $donnees['vente_annee']=number_format($this->totalVenduAnnee($year),0,',',' ');




        // dette
        //nbre de troncs vendus
        //
//accompte commande et incomplet du jour et de maniere globale




        return view('pages.home.dashbord',compact('donnees','date'));
    }

    public function totalVenteJour($date){
        return Vente::select(
                        DB::raw('DATE(ventes.created_at) as jour'),
                        DB::raw(' sum(ligne_ventes.prix_total) as montant'),
                        DB::raw(' sum(case when bois_produits.discriminant="'.Tronc::DISCRIMINANT.'" then 1 else 0 end) as quantite'
                        ),
                    )
                    ->join("ligne_ventes","ventes.id","ligne_ventes.vente_id")
                    ->join("bois_produits","ligne_ventes.bois_produit_id","bois_produits.id")
                    ->where("ventes.etat",'<>',VenteHaut::COMMANDE)
                    ->whereDate("ventes.created_at","$date")
                    ->groupBy('jour')
                    ->first();
    }

    public function totalPayeNonLivre(){
        $somme=LignePaiement::join('ventes','ligne_paiements.vente_id','ventes.id')
                            ->where('ventes.etat','like',VenteHaut::PAYE_NON_LIVRE)
                            ->sum('somme');
        $vente=LigneVente::join('ventes','ligne_ventes.vente_id','ventes.id')
                            ->where('ventes.etat','like',VenteHaut::PAYE_NON_LIVRE)
                            ->sum('prix_total');
        return $somme - $vente;
    }


    public function totalPayeNonLivreJour($date){
        return LignePaiement::join('ventes','ligne_paiements.vente_id','ventes.id')
                            ->where('ventes.etat','like',VenteHaut::PAYE_NON_LIVRE)
                            ->whereDate('ligne_paiements.created_at',$date)
                            ->sum('somme');
    }
    // total entrée journée
    public function totalEncaisseJour($date){
        return Transaction::where('somme','>',0)->whereDate('created_at',$date)->sum('somme');
    }

    //total sortie jour
    public function totalDepenseJour($date){
        return -1* Depense::whereDate('created_at',$date)->sum('somme') +
                         Transaction::where('somme','<',0)->whereDate('created_at',$date)->sum('somme');
    }


    //total sortie mois
    public function totalDepenseMois($month,$year){
        return -Depense::whereMonth("created_at",$month)
                      ->whereYear("created_at",$year)
                      ->sum('somme');
                +Transaction::where('somme','<',0)->
                whereMonth("created_at",$month)->
                whereYear('created_at',$year)->sum('somme');
    }


    public function totalVenteMois($month,$year){
        return Vente::select(
                        DB::raw('MONTH(ventes.created_at) as mois'),
                        DB::raw('YEAR(ventes.created_at) as annee'),
                        DB::raw(' sum(ligne_ventes.prix_total) as montant'),
                        DB::raw(' sum(case when bois_produits.discriminant="'.Tronc::DISCRIMINANT.'" then 1 else 0 end) as quantite'
                        ),
                    )
                    ->join("ligne_ventes","ventes.id","ligne_ventes.vente_id")
                    ->join("bois_produits","ligne_ventes.bois_produit_id","bois_produits.id")
                    ->whereMonth("ventes.created_at",$month)
                    ->whereYear("ventes.created_at",$year)
                    ->where("ventes.etat",'<>',VenteHaut::COMMANDE)
                    ->groupBy('mois','annee')
                    ->first();
    }

    // Annee
    public function totalVenduAnnee($year){
        return LigneVente::whereYear('created_at',$year)->sum('prix_total');
    }

    public function totalDepenseAnnee($year){
        return -1*Depense::whereYear('created_at',$year)->sum('somme')
                +Transaction::where('somme','<',0)->whereYear('created_at',$year)->sum('somme');
    }



    public function totalDette(){
        $total_paiement=LignePaiement::join('ventes','ligne_paiements.vente_id','ventes.id')
                                        ->where('ventes.etat','<>',VenteHaut::COMMANDE)
                                        ->sum('ligne_paiements.somme');
        $total_ventes=LigneVente::join('ventes','ligne_ventes.vente_id','ventes.id')
                                  ->where('ventes.etat','<>',VenteHaut::COMMANDE)
                                  ->sum('ligne_ventes.prix_total');
        return $total_ventes - $total_paiement;
    }


    public function encaissement_jour($date){
        $lignes=Transaction::whereDate('created_at',$date)->where('somme','>','0')->get();
        return  DataTables::of($lignes)
                ->addColumn("nom",function($ligne){
                    return $ligne->description;
                })
                ->addColumn('somme_f',function($ligne){
                    return number_format($ligne->somme,'0',',',' ')
                .view('npl::components.bagde.badge')
                    ->with('text','FCFA')
                    ->with('class','badge-success');;
                })
                ->rawColumns(['nom','somme_f',])
                ->toJson();
    }
    public function etat_caisse(){
        // Caisse::latest()->first();
        $caisse= DB::table('caisses')->orderBy('created_at', 'desc')->first();
        $montant_transaction=Transaction::where('created_at','>=',$caisse->created_at)->sum('somme');

        return $caisse->montant + $montant_transaction;
        
    }
    public function depense_jour($date){
        $transactions=Transaction::whereDate('created_at',$date)->where('somme','<','0')->get();
        return  DataTables::of($transactions)
                 ->addColumn('somme_f',function($transaction){
                    $badge= ($transaction->somme>0)?"badge-success":"badge-danger";
                    return view('npl::components.bagde.badge')
                    ->with('text',number_format($transaction->somme,0,","," ")."FCFA")                   
                    ->with('class',$badge);
                })
                ->addColumn("description_f",function($transaction){
                    
                        return $transaction->description;
                    

                })
                ->rawColumns(['somme_f','description_f'])
                ->toJson();
    }

}
