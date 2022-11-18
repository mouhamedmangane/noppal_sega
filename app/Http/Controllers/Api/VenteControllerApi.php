<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BoisProduit;
use App\Models\LignePaiement;
use App\Models\Transaction;
use App\Models\Vente;
use App\Service\VenteService;
use Illuminate\Http\Request;

class VenteControllerApi extends Controller{

    public function important($contactId){
        $vente=VenteService::lastImportantVente($contactId);

        if($vente!=null){
            $important=true;
            $vente->client;
            foreach($vente->ligne_ventes as $value){
                $value->bois_produit;
            }

        } else {$important=false;}

        return [
            "status"=>true,
            'important'=>$important,
            'data'=>$vente
        ];

    }

    public function vente($id){
        $vente=Vente::find($id);

        if($vente!=null){
            $vente->client;
            foreach($vente->ligne_ventes as $value){
                $value->bois_produit;
            }
        }

        return  $vente;
    }

    public function importants($search=""){

        $important_ids= VenteService::importants($search);
        $data=[];
        foreach($important_ids as $important_id){
            $data[]=$this->vente($important_id->id);
        }

        return[
            'status'=>true,
            'data'=>$data
        ];
    }

    public function ventetroncsCouper($id,$date){

        $vente=Vente::find($id);

        if($vente!=null){
            if($vente->client) $vente->client->telephones;
            $vente->ligne_ventes=$vente->tronc_couper($date);
        }

        return  $vente;
    }

    public function journees($date=''){
        if($date==''){
            $date=now()->format('Y-m-d');
        }

        $important_ids= VenteService::couperJournee($date);
        $last_tronc=VenteService::last_tronc_couper($date);
        $poids=VenteService::couperJourneePoidsTronc($date);
        $nombre=VenteService::couperJourneeNombreTronc($date);
        $data=[];
        foreach($important_ids as $important_id){
            $data[]=$this->ventetroncsCouper($important_id->id,$date);
        }

        return[
            'status'=>true,
            'data'=>[
                'ventes'=>$data,
                'total_kg'=>$poids,
                'total_tronc'=>$nombre,
                'jour'=>$date,
                "last_tronc"=>$last_tronc
            ]
        ];
    }


    public function traduireVente(){
        $transactions = Transaction::where('type','like','VS')->where('id','>',2698)->get();
        foreach($transactions as $transaction){
            $simple = $transaction->ligne_paiement;
            $lignePaiment= LignePaiement::find($simple->id);
            $transaction->description= $lignePaiment->description();
            $transaction->update();
        }

        return response()->json([
            'yes',
            $transactions->count(),

        ]);
    }

}
