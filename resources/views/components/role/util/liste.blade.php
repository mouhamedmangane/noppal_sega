<x-npl::data-table.simple
    class="ly-list-table"
    scrollY="100"
    name="myDataTable"
    url="{{ url('/param-compte/roles/data') }}"
    :columns="$getHeadTable()"
    dom="t"
    selectName="role_select"
    selectColWidth="150px"
    searchId="mySearch"
    :actions="[
        ['op'=>'Suppression','id'=>'supprimer_role_tb',
         'url'=>url('param-compte/roles'),'type'=>'action','method'=>'DELETE',
         'canSelect'=>'*','confirm'=>true,'typeAlert'=>'modal'
        ],
        ['op'=>'Archivage','id'=>'archiver_role_tb',
         'url'=>url('param-compte/roles/archiverMany'), 'type'=>'action',
         'canSelect'=>'*','confirm'=>true,'typeAlert'=>'modal'
        ],
        ['op'=>'Archivage','id'=>'desarchiver_role_tb',
         'url'=>url('param-compte/roles/desarchiverMany'),'type'=>'action',
         'canSelect'=>'*','confirm'=>true,'typeAlert'=>'modal'
        ],
        ['op'=>'Modification','id'=>'modifier_role_tb',
        'url'=>url('param-compte/roles'),
        'type'=>'link','canSelect'=>'1'
        ],
    ]"


/>
