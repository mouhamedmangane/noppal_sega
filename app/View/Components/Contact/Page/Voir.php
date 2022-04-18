<?php

namespace App\View\Components\Contact\Page;

use Illuminate\View\Component;

class Voir extends Component
{
    public $contact;

    public $couleur_info='success',
           $status_info="Actif",
           $compte_info='0 FCFA',
           $couleurCompte_info='success';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($contact)
    {
        $this->contact=$contact;
        if($contact->archiver==1){
            $this->couleur_info='danger';
            $this->status_info="Archivé";
        }

        if($contact->compte ){
            $this->compte_info= number_format($contact->compte ,0,'.',' ').' FCFA';
            if($contact->compte<0){
                $this->couleurCompte_info="danger";
            }
        }
        else{
            $this->couleurCompte_info="danger";
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.contact.page.voir');
    }
}
