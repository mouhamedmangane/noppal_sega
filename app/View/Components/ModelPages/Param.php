<?php

namespace App\View\Components\ModelPages;

use App\Util\Access;
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
            ->addNavItemModel("Reglement","reglement","shopping_basket")
            ->addNavItemModel("Transaction","transaction","shopping_basket")
            ->addNavItemModel("Achat","achat","shopping_basket")
            ->addNavItemModel("Depense","depense","straighten")
        )
        ->addNavBlocModel(
            NavModelFactory::navBlocModel()

            ->addNavItemModel("l'Entreprise","param-compte/entreprise","home_work",false,Access::canAccess('entreprise',['r']))
            ->addNavItemModel("Bois","bois","toll",false,Access::canAccess('bois',['r']))
            ->addNavItemModel("Type Depense","param-compte/type_depense","toll",false,Access::canAccess('type_depense',['r']))
            ->addNavItemModel("Epaisseur Planche","epaisseur_planche","height",false,Access::canAccess('epaisseur_planche',['r']))
            ->addNavItemModel("Role","param-compte/roles","gavel",false,Access::canAccess('role',['r']))
            ->addNavItemModel("Utilisateur","param-compte/users","group",false,Access::canAccess('user',['r']))
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
