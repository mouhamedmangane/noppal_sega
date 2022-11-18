<?php

namespace App\Models;

use App\ModelAbstract\ITransactionSimple;
use App\ModelFabrique\TransactionFabrique;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Npl\Brique\Util\DataBases\DoneByUser;

class LigneReglement extends Model implements ITransactionSimple
{
    use HasFactory;


    public const PAIEMENT_TYPE="PAIEMENT";


    public function getDescription()
    {
        return 'Paiement Reglement RS-'.$this->reglement_id;
    }

    public function save($somme=0,array $options=[]){
        if($somme==0)
            throw new Exception('la somme ne peut pas etre null');

        if($this->id==0){
            $transaction=TransactionFabrique::as($this,-$somme);
            $transaction->correspondant=$this->reglement_id;
            DoneByUser::inject($transaction);
            $transaction->save();
            $this->transaction_id=$transaction->id;
        }
        else{
            $transaction=$this->transaction;
            DoneByUser::inject($transaction);
            $transaction->somme=-$somme;
            $transaction->update($options);
        }

        parent::save($options);

    }

    // public function update($somme=0,array $options=[]){
    //     if($somme==0)
    //         throw new Exception('la somme ne peut pas etre null');
    //         $options['yy']='1';
    //     parent::update($options);

    // }

    public function reglement(){
        return $this->belongsTo(Reglement::class);
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }



}
