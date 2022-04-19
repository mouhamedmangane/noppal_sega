


    <x-npl::data-table.simple
        class="ly-list-table table-fixed"
        scrollY="100"
        name="myDataTable" url="{{ url('/depense/data/') }}" :columns="$getTitle()"
        idDivPaginate="bass-right" idDivInfo="bas-left" selectName="myDataTableSelect" searchId='mySearch'
        pageLength="25"
        groupByEnable="true"
        groupBy=""
        selectName="depense_select"
        selectColWidth="100px"
        pagingType="full"
        :actions="[
            ['op'=>'Suppression','id'=>'supprimer_depense_tb',
             'url'=>url('depense/destroyMany'),'type'=>'action','method'=>'DELETE',
             'canSelect'=>'*','confirm'=>true,'typeAlert'=>'modal'
            ],

            ['op'=>'Modification','id'=>'modifier_depense_tb',
            'url'=>url('depenses'),
            'type'=>'link','canSelect'=>'1'
            ],

            ['op'=>'Modification','id'=>'print_user_tb',
            'url'=>url('depense/print'),
            'type'=>'','canSelect'=>'1'
            ],
        ]"

    />


