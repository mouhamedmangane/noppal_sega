<?php

namespace App\View\Components\ModelPages;

use Illuminate\View\Component;
use Npl\Brique\ViewModel\Navs\NavModelFactory;

class Metier extends Component
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
            ->addNavItemModel("Dashbord",url('dashbord'),"home")
            ->addNavItemModel("Contact",url('sdfqsdf'),"account_box ")
            ->addNavGroupModel(NavModelFactory::navGroupModel("Produit","home")
                ->addNavItemModel("Tronc",url("sdfsdf"))
                ->addNavItemModel("Planche",url("dsfsdfsdf"))
                ->addNavItemModel("Ajustement",url("produit/ajustement"))
                ->addNavItemModel("Rejet",url("produit/rebut"))
            )

        )
        ->addNavBlocModel(
            NavModelFactory::navBlocModel()
            ->addNavItemModel("Vente",url("vente"),"shopping_cart")
            ->addNavItemModel("Achat",url("achat"),"receipt")
            ->addNavItemModel("Fournisseur",url("fournisseur"),"receipt")
            ->addNavItemModel("Depense",url("depense"),"remove_shopping_cart")

        )
        ->addNavBlocModel(
            NavModelFactory::navBlocModel()
            ->addNavItemModel("Integration","integration","integration_instructions")
            ->addNavItemModel("Rapport","rapport","flag")
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
        return view('components.model-pages.metier');
    }
}

