<?php

namespace App\ModelHaut;

use App\Models\Contact;

class ContactHaut {

    public static function updateCompte($idContact){
        if($idContact){
            $contact=Contact::where('id',$idContact)->first();
            $contact->compte=$contact->compteFinal();
            $contact->update();
        }

    }


}
