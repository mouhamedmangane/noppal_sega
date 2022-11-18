<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class LignePaiement extends Model implements ITransaction
{
    use HasFactory;
    public function description()
    {
        return "Paiement VS-".$this->vente->id." de : ".$this->vente->nom;
    }
    public function update_transaction(){
        $transaction=Transaction::findOrFail($this->transaction_id);
        $transaction->somme=$this->somme;
        return $transaction->save();

    }
    public function create_transaction()
    {
        try {
            DB::beginTransaction();

                $transaction= new Transaction();
                $transaction->somme=$this->somme;
                $transaction->description=$this->description();
                $transaction->done_by_user=$this->done_by_user;
                $transaction->type='VS';
                $transaction->created_at=$this->created_at;
                $transaction->correspondant=$this->vente_id;
                ($transaction->save());
                $this->transaction_id=$transaction->id;
                $this->save(true);


            DB::commit();
            return true;

        } catch (\Throwable $th) {
           DB::rollback();
           return false;
        }

    }

    public function save($dejaCreate=false,array $options = []){
        if(parent::save()){
            if(!$dejaCreate){
                return $this->create_transaction();
            }
            else{
                return $this->update_transaction();
            }

        }
        return true;

    }

    public function vente()
    {
        return $this->belongsTo('App\Models\Vente');
    }
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction');
    }



}
