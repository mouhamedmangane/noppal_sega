<?php

namespace App\View\Components\Contact\Util;

use Illuminate\View\Component;
use Npl\Brique\Util\NplStringFormat;
use Npl\Brique\ViewModel\NplEditorTableMd\GCellFactory;

class Create extends Component
{
    public $contact;
    public $vente;
    public $telephones=[
                ['indicatif'=>'','numero'=>'','id'=>0],
                ['indicatif'=>'','numero'=>'','id'=>0]
            ],
            $client_fournisseur=[false,false];


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($contact,$vente=null)
    {
        $this->contact=$contact;
        $this->vente=$vente;

        $tels=$contact->telephones;
        if($tels){
            $i=0;
            foreach ($tels as $key => $value) {
                $this->telephones[$i]['indicatif']=$value->indicatif;
                $this->telephones[$i]['numero']=$value->numero;
                $this->telephones[$i]['id']=$value->id;
                $i++;
            }
        }
        if($contact->id){
            $this->client_fournisseur[0]=(boolean) $contact->is_client;
            $this->client_fournisseur[1]=(boolean) $contact->is_fournisseur;
        }
        if($vente){
            $this->client_fournisseur[0]=true;

        }
        // dd($this->telephones);
    }

    public function valuesLignesVente(){
        $values=[];
        foreach ($this->contact->contact_prix as $key => $contact_prix) {
            $element=[];
            $element['bois']=$contact_prix->bois_id;
            $element['prix_vente']=$contact_prix->prix_vente;
            $element['prix_achat']=$contact_prix->prix_achat;
            $values[]=(Object)$element;
        }
        return $values;
    }
    public function getColumns(){
        $listBois=\App\Models\Bois::where('archived',0)->get()->toArray();



        $columns[]= GCellFactory::select("bois",'bois','bois')
                    ->setProp('name','id')
                    ->setData($listBois)
                     ->setClassTd('npl-editor-td-sm')
                    ->defaultOption('selectionner bois');
        $columns[]= GCellFactory::text('prix_vente','prix_vente','prix_vente')
                    ->type('number')
                    ->setClassTd('npl-editor-td-sm ')
                    ->setClassInput('npl-editor-prix-vente')
                    ->defaultValue('0');
        $columns[]= GCellFactory::text('prix_achat','prix_achat','prix_achat')
                    ->type('number')
                    ->setClassTd('npl-editor-td-md ')
                    ->setClassInput("npl-editor-prix-achat")
                    ->defaultValue('0');

        return $columns;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.contact.util.create');
    }
}
