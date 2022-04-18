<?php

namespace App\View\Components\VenteSega\Util;

use Illuminate\View\Component;

class Create extends Component
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

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function getColumns(){
        $columns=[];
        $categories = GroupeProduit::all();

        $columns[]= GCellFactory::select("bois",'bois','bois')
                    ->setProp('groupe_name','id')
                    ->setData($categories)
                    ->defaultOption('selectionner le bois');

        $columns[]= GCellFactory::selectFree('produits','produits','produits','bois',url('/venteProduit/categorie'))
                    ->setProp('libelle','id')
                    ->setData([
                    ])
                    ->unique(true)
                    ->defaultOption('selectionner Produit');
        $columns[]= GCellFactory::selectFree('Type','type','type','produits',url('/venteProduit/categorie'))
                    ->setProp('libelle','id')
                    ->setData([
                    ])
                    ->unique(true)
                    ->defaultOption('selectionner Produit');
        $columns[]= GCellFactory::text('quantiteD','quantite','quantite')
                    ->type('number')
                    ->setClassTd('npl-editor-td-sm')
                    ->defaultValue('0');
        $columns[]= GCellFactory::text('quantiteR','quantite','quantite')
                    ->type('number')
                    ->setClassTd('npl-editor-td-sm')
                    ->defaultValue('0');
         $columns[]= GCellFactory::text('unites','unites','unites')
                    ->type('string')
                    ->setClassTd('npl-editor-td-sm')
                    ->defaultValue('Unité');
        $columns[]= GCellFactory::text('prix','prix','prix')
                    ->type('number')
                    ->setClassTd('npl-editor-td-md')
                    ->defaultValue('0');
        $columns[]= GCellFactory::text('montantT','montantT','montantT')
                    ->type('number')
                    ->setClassTd('npl-editor-td-md  ')
                    ->defaultValue('0');

        return $columns;
    }

    public function render()
    {
        return view('components.vente-sega.util.create');
    }
}
