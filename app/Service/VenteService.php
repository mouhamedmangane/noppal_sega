<?php
namespace App\Service;

use App\ModelHaut\ContactHaut;
use App\ModelHaut\VenteHaut;
use App\Models\BoisProduit;
use App\Models\LigneVente;
use App\Models\Vente;
use Npl\Brique\Util\DataBases\DoneByUser;

class VenteService{

    // ImportantVente => accompte ou payé_non_livré
    static function lastImportantVente($contactId){
        $vente=Vente::where('contact_id',$contactId)
        ->orderBy('created_at','desc')
        ->first();
        if($vente!=null && ($vente->etat==VenteHaut::ACCOMPTE || $vente->etat==VenteHaut::PAYE_NON_LIVRE)){
            return $vente;
        }
        return null;
    }

    static function importantOrNewVente($contactId){
        $vente= self::lastImportantVente($contactId);
        if($vente == null){
            $vente=self::newVente($contactId);
        }
        return $vente;
    }

    static function newTroncCouper($contactId,BoisProduit $tronc){
        $ligne_vente=LigneVente::where('bois_produit_id',$tronc->id)->first();
        if(!$ligne_vente){
            $vente= self::importantOrNewVente($contactId);
            $ligneVente= VenteHaut::createLigneVente($tronc->id,$vente,1,$contactId,5,1);
        }

        $tronc->couper=now();
        $tronc->update();
        if(!$ligne_vente){
            VenteHaut::updateEtatVente($vente);
            ContactHaut::updateCompte($vente->contact_id);
        }

    }

    static function newVente($contactId,$nom='',$telephone=''){
        $vente=new Vente;
        $vente->etat=VenteHaut::COMMANDE;
        $is_new=true;
        DoneByUser::inject($vente,5);
        $vente->done_by_user=5;
        if($contactId!=0){
            $vente->contact_id = $contactId;
        }
        else{
            $vente->nom= $nom;
            $vente->telephone= $telephone;
        }
        $vente->save();

        return $vente;
    }


    public static function importants($search){
        return Vente::select('ventes.id')->join('ligne_ventes','ventes.id','ligne_ventes.vente_id')
                    ->join('bois_produits','ligne_ventes.bois_produit_id','bois_produits.id')
                    ->where(function($query){
                        $query->whereDate('bois_produits.created_at','>','2021-12-09');
                        $query->whereNull('bois_produits.couper');
                    })
                    ->orWhere('ventes.etat',VenteHaut::PAYE_NON_LIVRE)
                    ->orderBy('bois_produits.couper','desc')
                    ->distinct()
                    ->get();

    }

    public static function last_tronc_couper($jour){
        $produit=BoisProduit::whereDate('couper',$jour)->orderBy('couper','desc')->first();
        if($produit!=null){
            return $produit->id;
        }
        return 0;
    }

    public static function couperJournee($jour){
        return Vente::select('ventes.id')->join('ligne_ventes','ventes.id','ligne_ventes.vente_id')
                    ->join('bois_produits','ligne_ventes.bois_produit_id','bois_produits.id')
                    ->where(function($query)use($jour){
                        $query->whereDate('bois_produits.couper',$jour);
                    })
                    ->orWhere(function($query) use($jour){
                        $query->whereDate('ventes.created_at',$jour);
                    })
                    ->distinct()
                    ->orderBy('ventes.id','desc')
                    ->get();

    }

    public static function couperJourneePoidsTronc($jour){
        return BoisProduit::whereDate('couper',$jour)
                    ->sum('poids');

    }

    public static function couperJourneeNombreTronc($jour){
        return BoisProduit::whereDate('couper',$jour)
                    ->count();

    }


}
