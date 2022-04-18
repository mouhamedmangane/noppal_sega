<?php

namespace App\View\Components\Contact\Page;

use Illuminate\View\Component;

class Create extends Component
{
    public $contact;
    public $vente;
    public $couleur_info='success',
           $status_info="Actif",
           $compte_info='0 FCFA',
           $couleurCompte_info='success';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($contact,$vente=null)
    {
        $this->contact=$contact;
        $this->vente=$vente;
        if($contact->archiver==1){
            $this->couleur='danger';
            $this->status="Archivé";
        }
        if($contact->compte && $contact->compte>0){
            $this->compte_info= number_format($contact->compte,0,'.',' ').' FCFA';
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
        return view('components.contact.page.create');
    }
}
