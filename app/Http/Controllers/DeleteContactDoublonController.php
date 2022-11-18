<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use Illuminate\Http\Request;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class DeleteContactDoublonController extends Controller
{
    public function finish(){
        $collections=$this->getTelephones();
        try {
            DB::beginTransaction();
            foreach ($collections as $collect) {
               ($this->getVentesUpdated($collect));
               ($this->supprimerContactDoublon($collect));

                // if($this->supprimerContactDoublon($collect)==0){

                //         throw new \Exception('Supprimé Contact Non effectué ou tous les cartes sont déja supprimé' );
                //     }


            }
            DB::commit();
            return 'yes';
        } catch (\Exception $th) {
            return "ça ne s est pas bien passé ".$th->getMessage();
            DB::rollback();
        }

    }

    //recuperer tous les telephones qui appartient à au moins deux contact clients
    public function getTelephones(){
        $t=DB::select('SELECT numero,contacts.nom,contacts.id,contacts.created_at FROM telephones t,contacts WHERE t.contact_id=contacts.id and contacts.is_client=1 and t.numero IN(SELECT numero FROM telephones t2 WHERE t.id!=t2.id) ORDER BY numero');
       // dd(collect($t)->groupBy('numero'));
        return collect($t)->groupBy('numero');
    }
    //recuperer le premier client enregistré  l'id que doit
    //prendre les autres ventes
    public function getFirstClient($collect){
       // $collect=$this->getTelephones()->first();
        $c= $collect[0];
      for ($i=0; $i <count($collect) ; $i++) {
        if($c->created_at<$collect[$i]->created_at){
            $c= $collect[$i];
        }
      }
      return $c;

    }
    public function listerLeurVente(){
        $collections=$this->getTelephones();
        $ventes=[];
        foreach ($collections as $collect) {
           $ventes[]=Vente::whereIn('contact_id',$this->getIDclients($collect))->get();
        }
        return $ventes;

    }
    //recuperer les ventes des ces clients et
      //modifier les contact_id
    public function getVentesUpdated($collect){
       // $collect=$this->getTelephones()->first();
        $exceptC=$this->getFirstClient($collect);
        //return Vente::whereIn('contact_id',$this->getIDclients($collect))->get();
        return DB::table('ventes')
            ->whereIn('contact_id',$this->getIDclients($collect))
            ->update(['contact_id' => $exceptC->id]);

       //return 1 success
    }
    //les id des ventes -
    public function getIDclients($collect){
        $tabs=[];
        for ($i=0; $i <count($collect) ; $i++) {
           $tabs[]=$collect[$i]->id;
        }
        return $tabs;

    }


    //supprimer les contact_id doubles
    public function supprimerContactDoublon($collect){
        $id_except=$this->getFirstClient($collect)->id;
        return DB::table('contacts')
        ->where('id','!=',$id_except)
        ->whereIn('id',$this->getIDclients($collect))->delete();
    }
}
