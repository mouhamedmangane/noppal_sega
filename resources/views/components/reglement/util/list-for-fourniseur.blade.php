<x-npl::data-table.simple
class="ly-list-table table-fixed"
scrollY="100"
name="myDataTable" url="{{ url('reglement/fournisseur/'.$fournisseur->id.'/data') }}" :columns="$getTitle()"
idDivPaginate="bass-right" idDivInfo="bas-left" selectName="myDataTableSelect" searchId='mySearch'
pageLength="25"
selectName="reglement_select"
selectColWidth="100px"
pagingType="full"
:actions="[
    ['op'=>'Suppression','id'=>'supprimer_reglement_tb',
     'url'=>url('reglement/many'),'type'=>'action','method'=>'DELETE',
     'canSelect'=>'*','confirm'=>true,'typeAlert'=>'modal'
    ],

    ['op'=>'Modification','id'=>'modifier_reglement_tb',
    'url'=>url('reglements'),
    'type'=>'link','canSelect'=>'1'
    ],


]"

/>
