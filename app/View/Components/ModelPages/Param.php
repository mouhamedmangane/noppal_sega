<?php

namespace App\View\Components\ModelPages;

use Illuminate\View\Component;
use Npl\Brique\ViewModel\Navs\NavModelFactory;

class Param extends Component
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

    public  function getSidebarData(){

        return NavModelFactory::navModel()
        ->addNavBlocModel(
            NavModelFactory::navBlocModel()
            ->addNavItemModel("Dashbord","/home","dashboard")
            ->addNavItemModel("Contact","contact","person")
            ->addNavItemModel("Tronc","tronc","blur_circular")
            ->addNavItemModel("Planche","planche","straighten")
        )
        ->addNavBlocModel(
            NavModelFactory::navBlocModel()
            ->addNavItemModel("Vente","vente","shopping_cart")
            ->addNavItemModel("Achat","achat","shopping_basket")
            ->addNavItemModel("Fournisseur","fournisseur","shopping_basket")
            ->addNavItemModel("Depense","depense","straighten")
        )
        ->addNavBlocModel(
            NavModelFactory::navBlocModel()

            ->addNavItemModel("l'Entreprise","param-compte/entreprise","home_work")
            ->addNavItemModel("Bois","bois","toll")
            ->addNavItemModel("Type Depense","param-compte/type_depense","toll")
            ->addNavItemModel("Epaisseur Planche","epaisseur_planche","height")
            ->addNavItemModel("Role","param-compte/roles","gavel")
            ->addNavItemModel("Utilisateur","param-compte/users","group")
            ->access('bois',['c'])
        )
        ->activer();


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.model-pages.param');
    }
}
