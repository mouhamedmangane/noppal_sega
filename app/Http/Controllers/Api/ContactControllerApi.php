<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactControllerApi extends Controller{
    public function contactRecente($search=""){
        $data=[];
        if(!empty($search)){
            $data_a=Contact::select('contacts.id')
                         ->join('telephones','contacts.id','telephones.contact_id')
                         ->where('contacts.nom','like',"%$search%")
                         ->orWhereRaw(" concat(cast(telephones.indicatif as varchar(4)),cast(telephones.numero as varchar(15))) like '%$search%' ")
                         ->get();
        }
        else{
            $date=now()->format('Y-m-d');
            $data_a=Contact::select('contacts.id',)
                         ->join('ventes','contacts.id','ventes.contact_id')
                         ->join("ligne_ventes",'ventes.id','ligne_ventes.vente_id')
                         ->join('bois_produits','ligne_ventes.bois_produit_id','bois_produits.id')
                         ->whereNotNull('bois_produits.couper')
                         ->orWhere(function($query)use($date){
                             $query->whereNull('bois_produits.couper');
                             $query->whereDate('ventes.created_at',$date);
                         })
                         ->orderBy('bois_produits.couper','desc')
                         ->distinct()
                         ->limit(10)
                         ->get();



        }
        foreach($data_a as $value){
            $item=Contact::find($value->id);
            $item->telephones;
            $data[]=$item;

        }


        return [
            'status'=>true,
            'data'=>$data,
        ];


    }
}
