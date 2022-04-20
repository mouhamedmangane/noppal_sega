<?php

namespace App\Http\Controllers;

use App\ModelHaut\Tronc;
use App\ModelHaut\VenteHaut;
use App\Models\LignePaiement;
use App\Models\LigneVente;

use App\Models\Vente;
use DateTime;
use Illuminate\Http\Request;
use DB;

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

        $totalVenteJour=$this->totalVenteJour($date);
        $totalVenteMois=$this->totalVenteMois($datetime->format('m'),$datetime->format('Y'));
        $donnees=[];
        $donnees['nbre_accompte']=Vente::where('etat',VenteHaut::ACCOMPTE)->count();
        $donnees['caisse_jour']=(isset($totalVenteJour->montant))?
                                number_format($totalVenteJour->montant,0,',',' '):0;
        $donnees['nbre_troncvbsdfg ']=(isset($totalVenteJour->quantite))?
                                nmber_format($totalVenteJour->quantite,0,',',' '):0;
        $donnees['caisse_mois']=(isset($totalVenteMois->montant))?
                                number_format($totalVenteMois->montant,0,',',' '):0;
        $donnees['nbre_tronc_mois']=(isset($totalVenteMois->quantite))?
                                number_format($totalVenteMois->quantite,0,',',' '):0;

        $donnees['dette']=number_format($this->totalDette(),0,',',' ');


        $donnees['total_encaisse']= $this->chmtotalEncaisse($date);


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

    public function totalEncaisse($date){
        return LignePaiement::whereDate('created_at',$date)->sum('somme');
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



    public function totalDette(){
        $total_paiement=LignePaiement::join('ventes','ligne_paiements.vente_id','ventes.id')
                                        ->where('ventes.etat','=',VenteHaut::ACCOMPTE)
                                        ->sum('ligne_paiements.somme');
        $total_ventes=LigneVente::join('ventes','ligne_ventes.vente_id','ventes.id')
                                  ->where('ventes.etat','=',VenteHaut::ACCOMPTE)
                                  ->sum('ligne_ventes.prix_total');
        return $total_ventes - $total_paiement;
    }


}
