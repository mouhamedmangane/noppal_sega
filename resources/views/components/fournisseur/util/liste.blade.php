


    <x-npl::data-table.simple
        class="ly-list-table table-fixed"
        scrollY="100"
        name="myDataTable" url="{{ url('/fournisseur/data/') }}" :columns="$getTitle()"
        idDivPaginate="bass-right" idDivInfo="bas-left" selectName="myDataTableSelect" searchId='mySearch'
        pageLength="25"
        groupByEnable="true"
        groupBy=""
        selectName="fournisseur_select"
        selectColWidth="100px"
        pagingType="full"
        :actions="[
            // ['op'=>'Suppression','id'=>'supprimer_achat_tb',
            //  'url'=>url('achat/many'),'type'=>'action','method'=>'DELETE',
            //  'canSelect'=>'*','confirm'=>true,'typeAlert'=>'modal'
            // ],

            // ['op'=>'Modification','id'=>'modifier_achat_tb',
            // 'url'=>url('achats'),
            // 'type'=>'link','canSelect'=>'1'
            // ],

            // ['op'=>'Modification','id'=>'print_user_tb',
            // 'url'=>url('achat/print'),
            // 'type'=>'','canSelect'=>'1'
            // ],
        ]"

    />
