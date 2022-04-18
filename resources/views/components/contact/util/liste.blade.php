<x-npl::data-table.simple
    class="ly-list-table"
    scrollY="100"
    name="myDataTable"
    url="{{ url('contact/data') }}"
    :columns="$getHeadTable()"
    idDivPaginate="bass-right"
    idDivInfo="bas-left"
    groupByEnable="true"
    groupBy=""
    selectName="contact_select"
    selectColWidth="150px"
    searchId="mySearch"
    :actions="[
        ['op'=>'Suppression','id'=>'supprimer_contact_tb',
         'url'=>url('contact/destroyMany'),'type'=>'action','method'=>'DELETE',
         'canSelect'=>'*','confirm'=>true,'typeAlert'=>'modal'
        ],
        ['op'=>'Archivage','id'=>'archiver_contact_tb',
         'url'=>url('contact/archiverMany'), 'type'=>'action',
         'canSelect'=>'*','confirm'=>true,'typeAlert'=>'modal'
        ],
        ['op'=>'Archivage','id'=>'desarchiver_contact_tb',
         'url'=>url('contact/desarchiverMany'),'type'=>'action',
         'canSelect'=>'*','confirm'=>true,'typeAlert'=>'modal'
        ],
        ['op'=>'Modification','id'=>'modifier_contact_tb',
        'url'=>url('contact/{id}/edit'),
        'type'=>'link','canSelect'=>'1'
        ],
    ]"

/>
