<?php

namespace Npl\Brique\View\Components\NoppalEditorTable;

use Illuminate\View\Component;
use Npl\Brique\ViewModel\NplEditorTableMd\GCellFactory;

class Table extends Component
{
    public $idTable,$columns,$dd;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($idTable,$columns,$dd=null)
    {
        $this->idTable = $idTable;
        $this->columns = $columns;
        $this->dd  =$dd;
    }
    public function getColumns(){
        $columns=[];
        $columns[]= GCellFactory::select("categorie",'categorie','categorie')
                    ->setProp('text','value')
                    ->setData([
                        (object)['value'=>'ct1','text'=>'informatique'],
                        (object)['value'=>'ct2','text'=>'boutique'],
                        (object)['value'=>'ct3','text'=>'boutique'],
                    ])
                    ->defaultOption('selectionner categorie');
        $columns[]= GCellFactory::selectFree('produit','produit','produit','categorie',url('/test/categorie'))
                    ->setProp('text','value')
                    ->setData([
                        
                            'ct1'=>[
                                (object)['value'=>'1','text'=>'premier','zzz'=>[]],
                                (object)['value'=>'2','text'=>'deuxieme','zzz'=>56],
                                (object)['value'=>'3','text'=>'troisime','zzz'=>570],
                                (object)['value'=>'4','text'=>'quatriéme','zzz'=>80]
                            ],
                           'ct2'=>[
                              (object)['value'=>'5','text'=>'cinq'],
                              (object)['value'=>'8','text'=>'huit'],
                              (object)['value'=>'6','text'=>'six'],
                              (object)['value'=>'4','text'=>'quatriéme']
                           ],
                         
                    ])
                    ->unique(true)
                    ->defaultOption('selectionner Produit');
        $columns[]= GCellFactory::text('prix','prix','prix')
                    ->type('number')
                    ->defaultValue(0);
        return $columns;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('npl::components.noppal-editor-table.table');
    }
}
