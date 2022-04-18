<?php
namespace App\View\Components\Vente\Page;

use App\ModelHaut\VenteHaut;
use Illuminate\View\Component;
use DataTables;

class VoirVente extends Component
{
    public $vente;
    public $is_commande=false,
            $is_accompte=false,
            $is_complete=false;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($vente)
    {
        $this->vente=$vente;
        $this->is_commande= $this->vente->etat==VenteHaut::COMMANDE;

        $this->is_accompte= $this->vente->etat==VenteHaut::ACCOMPTE;

        $this->is_complete= $this->vente->etat==VenteHaut::COMPLETE;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */

    public function render()
    {
        return view('components.vente.page.voir-vente');
    }
}
