<?php

namespace App\View\Components\Vente\Util;

use App\ModelHaut\Planche;
use App\ModelHaut\Tronc;
use App\ModelHaut\VenteHaut;
use App\Models\EpaisseurBois;
use Illuminate\View\Component;
use App\Models\Telephone;
use Npl\Brique\Util\NplStringFormat;
use DataTables;

class VoirVente extends Component
{
    public $vente;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($vente)
    {
        $this->vente=$vente;



    }





    public function titlePayement(){
        return [
            (object) ['name'=>'Date Paiement','propertyName'=>'date'],
            (object) ['name'=>'Montant Reçu','propertyName'=>'montant'],
            (object) ['name'=>'Actions','propertyName'=>'actions'],


        ];

    }
    public function titre(){
        $data= [
            (object)  ['name'=>'Bois','propertyName'=>'bois'],
            (object)  ['name'=>'Produit','propertyName'=>'produit'],
            (object)  ['name'=>'Quantite  ','propertyName'=>'quantite'],
            (object)  ['name'=>'Prix Unitaire','propertyName'=>'prix_unite'],
            (object)  ['name'=>'Montant Total','propertyName'=>'prix_total'],

        ];

    //    dd($data);


        return $data;
    }
    public function ventes(){
        $ligneVentes=$this->vente->ligne_ventes();

      //  dd($this->vente->ligne_ventes());

        $dataTable = DataTables::of($ligneVentes)
        ->addColumn('produit',function($ligneVentes){
            $bp=$ligneVentes->bois_produit;
            if($bp->discriminant==Planche::DISCRIMINANT){
                $epaisseur=EpaisseurBois::where('id',$bp->epaisseur)->first();
                if($epaisseur){
                    $epaisseur=$epaisseur->nom;
                }
                else{
                    $epaisseur=$bp->epaisseur;
                }
                return $bp->bois->name.' '.
                    $bp->m3." m³ / ".$epaisseur.' / '.$bp->longueur.' x '.$bp->largueur;
            }
            else{
                return view('npl::components.links.simple')
                ->with('url',url("tronc/".$bp->id))
                ->with('text',$bp->identifiant)
                ->with('class','lien-sp').' / '.$bp->bois->name." ".$bp->poids.' Kg';
            }

        })
        ->addColumn('bois',function($ligneVentes){
            return $ligneVentes->bois_produit->discriminant;
            })


        ->addColumn('quantite',function($ligneVentes){
            $quantite=$ligneVentes->quantite;
                if($ligneVentes->bois_produit->discriminant==Tronc::DISCRIMINANT){
                        $quantite=$ligneVentes->bois_produit->poids;
                }
            return
            view('npl::components.bagde.compare')
            ->with('text1',number_format($quantite,'0',' ',' '))
            ->with('text2','kg')
            ->with('separateur',' ')
            ->with('className','badge-success mr-2');
        })
        ->addColumn('prix_unite',function($ligneVentes){
            return $ligneVentes->prix_total / $ligneVentes->bois_produit->poids.' F';

        })
        ->rawColumns(['bois','produit','quantite',"prix_unite",'prix_total'])
        ->make(true);
      //  dd($dataTable);
        $response=$dataTable->getData(true);
    //    dd($response['data']);
        return $response['data'];
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.vente.util.voir-vente');
    }
}
