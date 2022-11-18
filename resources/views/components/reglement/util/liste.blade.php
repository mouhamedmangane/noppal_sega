


        <x-npl::data-table.simple
        class="ly-list-table table-fixed"
        scrollY="100"
        name="myDataTable" url="{{ url('/reglement/data/') }}" :columns="$getTitle()"
        idDivPaginate="bass-right" idDivInfo="bas-left"
        searchId='mySearch'
        pageLength="25"
        afterLoadFunction="afterLoadVente"

        selectColWidth="100px"
        pagingType="full"


    />


