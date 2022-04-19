<?php

namespace App\View\Components\Achat\Page;

use App\Models\Contact;
use Illuminate\View\Component;

class Liste extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function urlFournisseur(){
        $urls=[];
        $fournisseurs=Contact::where('is_fournisseur',1)->get();
        foreach($fournisseurs as $fournisseur){
            $url=url('achat/datas/fournisseur/').'/'.$fournisseur->id;
            $urls[$url]=$fournisseur->nom;
        }
        return $urls;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.achat.page.liste');
    }
}
