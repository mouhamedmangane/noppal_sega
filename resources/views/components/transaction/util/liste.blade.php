


    <x-npl::data-table.simple
    class="ly-list-table table-fixed"
    scrollY="100"
    name="myDataTable" url="{{ url('/transaction/data/') }}" :columns="$getTitle()"
    idDivPaginate="bass-right" idDivInfo="bas-left" selectName="myDataTableSelect" searchId='mySearch'
    pageLength="25"
    groupByEnable="true"
    groupBy=""
    selectName="transaction_select"
    selectColWidth="100px"
    pagingType="full"
    :actions="[
        ['op'=>'Suppression','id'=>'supprimer_transaction_tb',
         'url'=>url('transaction/destroyMany'),'type'=>'action','method'=>'DELETE',
         'canSelect'=>'*','confirm'=>true,'typeAlert'=>'modal'
        ],

        ['op'=>'Modification','id'=>'modifier_transaction_tb',
        'url'=>url('transactions'),
        'type'=>'link','canSelect'=>'1'
        ],

        ['op'=>'Modification','id'=>'print_user_tb',
        'url'=>url('transaction/print'),
        'type'=>'','canSelect'=>'1'
        ],
    ]"

/>


