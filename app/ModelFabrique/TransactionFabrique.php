<?php
namespace App\ModelFabrique;

use App\ModelAbstract\ITransactionSimple;
use App\Models\Transaction;

class TransactionFabrique{

    public static function simple(ITransactionSimple $simple){
        $transaction=new Transaction;
        $transaction->description=$simple->getDescription();
        return $transaction;
    }


    public static function as(ITransactionSimple $simple,$somme){
        $transaction = self::simple($simple);
        $transaction->somme=$somme;
        $transaction->type='AS';
        return $transaction;
    }

    public static function vs(ITransactionSimple $simple){
        $transaction = self::simple($simple);
        $transaction->type='VS';
        return $transaction;
    }
}
