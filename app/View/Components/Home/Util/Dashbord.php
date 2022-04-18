<?php

namespace App\View\Components\Home\Util;

use App\Models\Bois;
use App\Models\LignePaiement;
use App\Models\LigneVente;
use App\Models\Vente;
use DateTime;
use Illuminate\View\Component;
use DB;
use PhpParser\Node\Stmt\Foreach_;

class Dashbord extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $donnees;
    public $date;
    public $month,$year;

    //pour le graph
    public $evolutionVente,$list_jour;

    public $evolutionVenteAnneeData,$list_mois;

    public function __construct($date,$donnees)
    {
        $this->date=new DateTime($date);
        $this->donnees=$donnees;
        $this->month=$this->date->format('m');
        $this->year=$this->date->format('Y');
        $this->evolutionVente=$this->evolutionVenteMois($this->date->format('m'),$this->date->format('Y'));
        $this->list_jour=range(1,$this->date->format('t'));

        $this->evolutionVenteAnneeData=$this->evolutionVenteAnnee();
        $this->list_mois= range(1,12);
    }



    public function evolutionVenteMois($month,$year){
        return Vente::select(
                DB::raw('DAY(ventes.created_at) as jour'),
                DB::raw('DATE(ventes.created_at) as journee'),
                DB::raw(' sum(ligne_ventes.prix_total) as montant')
        )
        ->join("ligne_ventes","ventes.id","ligne_ventes.vente_id")
        ->whereMonth("ventes.created_at",$month)
        ->whereYear("ventes.created_at",$year)
        ->groupBy('journee','jour')
        ->get();
    }

    public function evolutionVenteAnnee(){
        return Vente::select(
                DB::raw('YEAR(ventes.created_at) as annee'),
                DB::raw('Month(ventes.created_at) as mois'),
                DB::raw('sum(ligne_ventes.prix_total) as montant')
        )
        ->join("ligne_ventes","ventes.id","ligne_ventes.vente_id")
        // ->whereMonth("ventes.created_at",$this->month)
        ->whereYear("ventes.created_at",$this->year)
        ->groupBy('mois','annee')
        ->get();
    }

    public function TroncMieuxVendu(){
        return Vente::select(
                DB::raw('bois.name as myname'),
                DB::raw(' sum(bois_produits.poids) as poids')
        )
        ->RightJoin("ligne_ventes","ventes.id","ligne_ventes.vente_id")
        ->Leftjoin("bois_produits","ligne_ventes.bois_produit_id","bois_produits.id")
        ->Leftjoin("bois","bois_produits.bois_id","bois.id")
        ->whereMonth("ventes.created_at",$this->month)
        ->whereYear("ventes.created_at",$this->year)
        ->groupBy('bois.name')
        ->get();
    }

    public function my_array_exists_key($keyy,$arr){
        foreach ($arr as $key => $value) {
            if($key==$keyy)
                return true;
        }

        return false;
    }

    public function TroncMieuxVenduData(){
        $tv= $this->TroncMieuxVendu()->pluck('poids','myname');

        $tab=[];
        foreach ($this->TroncMieuxVendu_titre() as $key => $value) {
            // dd([
            //     $value,$tv,$this->my_array_exists_key($value,$tv)
            // ]);
            if($this->my_array_exists_key($value,$tv))
            {
                $tab[]=$tv[$value];
            }
            else{
                $tab[]=0;
            }
        }
        return $tab;
    }



    public function TroncMieuxVendu_titre(){
        return Bois::where('archived',0)->get()->pluck('name')->toArray();
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.home.util.dashbord');
    }
}
