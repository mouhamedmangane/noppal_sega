<?php

namespace App\Models;

use App\ModelHaut\VenteHaut;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Npl\Brique\Util\NplStringFormat;

class Contact extends Model
{
    use HasFactory;

    public function ventes()
    {
        return $this->hasMany('App\Models\Vente');
    }


    public function telephones(){
        return $this->hasMany('App\Models\Telephone');
    }

    public function sumVente(){
        return LigneVente::join("ventes","ligne_ventes.vente_id",'ventes.id')
                     ->join("contacts","ventes.contact_id","contacts.id")
                     ->where('contacts.id',$this->id)
                     ->where('ventes.etat','<>',VenteHaut::COMMANDE)
                     ->sum("ligne_ventes.prix_total");
    }
    public function sumPaiement(){
        return LignePaiement::join("ventes","ligne_paiements.vente_id",'ventes.id')
                     ->join("contacts","ventes.contact_id","contacts.id")
                     ->where('contacts.id',$this->id)
                     ->sum("ligne_paiements.somme");
    }

    public function compteFinal(){
        return $this->sumPaiement() - $this->sumVente();

    }

    public function contact_prix(){
        return $this->hasMany('App\Models\ContactPrix','contact_id','id');
    }

    public function nameAndPhone(){
        $telephones= Telephone::where('contact_id',$this->id)->get();
        $text="";
         if(count($telephones)>0){

            foreach($telephones as $key=>$tel){
                if($key!=0){
                    $text.=' / ';
                }
                $text.=NplStringFormat::telephone($tel->numero.'',$tel->indicatif.'');
            }
        }
        return $this->nom.' : '.$text;
    }
}
