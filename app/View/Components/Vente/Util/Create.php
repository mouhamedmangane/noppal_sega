<?php

namespace App\View\Components\Vente\Util;

use App\ModelHaut\Planche;
use App\ModelHaut\Tronc;
use App\Models\BoisProduit;
use App\Models\Contact;
use App\Models\ContactPrix;
use App\Models\EpaisseurBois;
use App\Models\Telephone;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Npl\Brique\Util\NplStringFormat;
use Npl\Brique\ViewModel\NplEditorTableMd\GCellFactory;

class Create extends Component
{
    public $vente;
    public $clients=[];
    public $planches=[];
    public $troncs=[];
    /**$this->
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model=null)
    {
        $this->vente=$model;
            $clients=[];
            $clients[0]="Client Non Enregistré";
            $contacts=Contact::where("is_client",1)->orderBy('nom','asc')->get();
            $text="";
            foreach ($contacts as $key => $value) {
                $telephones= Telephone::where('contact_id',$value->id)->get();
                if(count($telephones)>0){
                    $text=NplStringFormat::telephone($telephones[0]->numero.'',$telephones[0]->indicatif.'');
                }
                if(count($telephones)>1){
                    $text.=' / '.NplStringFormat::telephone($telephones[1]->numero.'',$telephones[1]->indicatif.'');
                }
                $clients[$value->id]=$value->nom.' / '.$text;
            }

            $this->clients=$clients;

        Planche::query()->where("quantite",'>',1)->get()->each(function($item,$key){
            $ep=$item->epaisseur;
            $epaisseur=($ep)?$ep->nom:$item->epaisseur_bois_id.' cm';
            $item->nom_produit=$item->bois->name.' '.$item->m3." m³ / ".$epaisseur.' / '.$item->longueur.'x'.$item->largueur;
            $this->planches[]=$item;
        });

        Tronc::query()->where("archived",0)->get()->each(function($item,$key){
            $ep=$item->epaisseur;
            $epaisseur=($ep)?$ep->nom:$item->epaisseur_bois_id.' cm';
            $item->nom_produit=$item->identifiant.' / '.$item->bois->name." ".$item->poids.' Kg';
            $this->troncs[]=$item;
        });

        if($this->vente){
            $planche=$this->planches;
            $this->vente->ligne_ventes->each(function($ligne,$key)use($planche){
                $item=$ligne->bois_produit;

                if($item->discriminant==Planche::DISCRIMINANT){
                    $test=true;
                    foreach ($planche as  $value) {
                        if($value->id==$item->id){
                            $test=false;
                            break;
                        }
                    }
                    if($test){
                        $ep=$item->epaisseur;
                        $epaisseur=($ep)?$ep->nom:$item->epaisseur_bois_id.' cm';
                        $item->nom_produit=$item->bois->name.' '.$item->m3." m³ / ".$epaisseur.' / '.$item->longueur.'x'.$item->largueur;
                        $this->planches[]=$item;
                    }

                }
                else{
                    $ep=$item->epaisseur;
                    $epaisseur=($ep)?$ep->nom:$item->epaisseur_bois_id.' cm';
                    $item->nom_produit=$item->identifiant.' / '.$item->bois->name." ".$item->poids.' Kg';
                    $this->troncs[]=$item;
                }


            });
        }


    }
    public function valuesLignesVente(){
        $values=[];
        foreach ($this->vente->ligne_ventes as $key => $ligne) {
            $element=[];
            if(Tronc::DISCRIMINANT==$ligne->bois_produit->discriminant){
                $element['categories']=1;
                $element['prix']=$ligne->prix_total/$ligne->bois_produit->poids;
            }
            else{
                $element['categories']=2;
                $element['prix']=$ligne->prix_total/$ligne->bois_produit->m3;
            }

            $element['produits']=$ligne->bois_produit_id;
            $element['quantite']=$ligne->bois_produit->poids;
            $element['montantT']=$ligne->prix_total;

            $values[]=(Object)$element;
        }
        return $values;
    }
    public function getColumns(){
        $columns=[];
        $planches=[];


        $columns[]= GCellFactory::select("categories",'categories','categories')
                    ->setProp('nom','id')
                    ->setData([
                        (object)['id'=>'2','nom'=>"Planche"],
                     ])
                     ->setClassTd('npl-editor-td-sm')
                    ->defaultOption('Tronc',1);

        $columns[]= GCellFactory::selectFree('produits','produits','produits','categories',url('/venteProduit/categorie'))
                    ->setProp('nom_produit','id')
                    ->setData([
                        1 => $this->troncs,
                        2 => $this->planches
                    ])
                    ->unique(true)
                    ->defaultOption('selectionner Produit')
                    ->setClassInput('npl-editor-produits select2 w-100')
                    ;
        $columns[]= GCellFactory::text('quantite','quantite','quantite')
                    ->type('number')
                    ->setClassTd('npl-editor-td-sm ')
                    ->setClassInput('npl-editor-quantite')
                    ->defaultValue('0');
        $columns[]= GCellFactory::text('prix','prix','prix')
                    ->type('number')
                    ->setClassTd('npl-editor-td-md ')
                    ->setClassInput("npl-editor-prix")
                    ->defaultValue('0');
        $columns[]= GCellFactory::text('montantT','montantT','montantT')
                    ->type('number')
                    ->setClassTd('npl-editor-td-md  ')
                    ->setClassInput("editor_montantT npl-editor-montant")
                    ->defaultValue('0');

        return $columns;
    }

    public function contactPrix(){
        if($this->vente->contact_id){
            return ContactPrix::where('contact_id',$this->vente->id)->get();

        }
        else{
            return [];
        }
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.vente.util.create');
    }
}
