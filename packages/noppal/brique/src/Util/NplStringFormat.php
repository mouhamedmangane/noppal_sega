<?php
namespace Npl\Brique\Util;

class NplStringFormat{

    public static function telephone(string $phone,string $indicatif=""){
        $formated_phone="";
        if(!empty($indicatif)){
            $formated_phone.="(+$indicatif) ";
        }
        $i=0;
        $tab_pas=[2,3,2];
        $pas=current($tab_pas);
        $lenght=strlen($phone);
        while($i<$lenght){
            $t[]=$i;
            if($i!=0)
                $formated_phone.=' ';
            $formated_phone.=substr($phone,$i,$pas);
            $i+=$pas;



            $next=next($tab_pas);
            if($next>1)
                $pas=$next;

        }
        return $formated_phone;
    }
}
