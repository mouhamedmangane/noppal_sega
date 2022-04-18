


        <x-npl::data-table.simple
            class="ly-list-table table-fixed"
            scrollY="100"
            name="myDataTable" url="{{ url('/vente/data/') }}" :columns="$getTitle()"
            idDivPaginate="bass-right" idDivInfo="bas-left" selectName="myDataTableSelect" searchId='mySearch'
            pageLength="25"
            afterLoadFunction="afterLoadVente"
            groupByEnable="true"
            groupBy=""
            selectName="vente_select"
            selectColWidth="100px"
            pagingType="full"
            :actions="[
                ['op'=>'Suppression','id'=>'supprimer_vente_tb',
                 'url'=>url('vente/many'),'type'=>'action','method'=>'DELETE',
                 'canSelect'=>'*','confirm'=>true,'typeAlert'=>'modal'
                ],

                ['op'=>'Modification','id'=>'modifier_vente_tb',
                'url'=>url('ventes'),
                'type'=>'link','canSelect'=>'1'
                ],

                ['op'=>'Modification','id'=>'print_user_tb',
                'url'=>url('vente/print'),
                'type'=>'','canSelect'=>'1'
                ],
            ]"

        />


{{--
    pagingType


    --}}
