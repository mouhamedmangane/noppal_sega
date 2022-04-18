<?php

namespace App\ModelHaut;



class AchatHaut {
    public const TYPE_DEPENSE_PAIE="Paie Achat";
    public const TYPE_DEPENSE_FRAIS="Frais Achat";

    public static function type_depense_client($type_depense_server){
        return ($type_depense_server==self::TYPE_DEPENSE_PAIE)?'paie':'frais';
    }






}
