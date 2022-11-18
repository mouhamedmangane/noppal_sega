<?php
namespace App\Service;

use App\Models\Transaction;
use Npl\Brique\Models\Objet;

class TransactionService{

    // Creer une transaction

    static function createTransaction($objet){
        switch (get_class($objet)) {
            case 'Transaction':
                # code...
                break;
            case 'Vente':
                # code...
                break;
            case 'Achat':
                # code...
                break;
                
            default:
                # code...
                break;
        }
    }
    static function createTransactionDepense(Transaction $trans){

    }


    


}
