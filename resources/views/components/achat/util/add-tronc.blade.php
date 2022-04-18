<div class="px-3">

    <form action="{{ url('achat/tronc_save/'.$achat->id)}}" id="add_tronc_achat" class=" px-1 " method="post">
            @csrf
            <input type="hidden" name="id" value="0" id="tronc_id">
        <div class="row bg-black bg-success" id="achat_form_content">
            <div class="col-md-6 col-sm-6">
                <div class="row" text='{"asss":[1,]}'>
                    <div class="col-md-6 col-sm-12 mt-1">
                        <x-npl::input.text name="poids" placeholder="Poids" required="true" id="poids_tronc" typpe="number" step="0.2"  class="form-control-sm"/>
                    </div>
                    <div class="col-md-6 col-sm-12 mt-1 mb-sm-1">
                        <x-npl::input.select name="bois" required="true" id="bois_tronc" :dt="$bois" class="custom-select-sm" />

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6">
                <div class="row">
                    <div class="col-md-6 col-sm-12 text-center mt-1" >
                        <span class="text-white" id="numero_tronc" style="font-size: 20px;"> ---</span>
                    </div>
                    <div class="col-md-6 col-sm-12 mt-1 text-align-center">

                        <div class="d-flex justify-content-center">
                            <x-npl::input.button-submit  id="test-button-submit"
                            idForm="add_tronc_achat"
                            idContentAlert="addAchatAlert"
                            class="btn btn-primary  d-flex align-items-center mb-1"
                            jeton="auto"
                            text="Ajouter"
                            icon="add"/>
                        </div>
                    </div>
                </div>

            </div>



        </div>
    </form>

    <div class="mt-2 w-100" style="overflow-x: auto;">
        <x-npl::data-table.simple
            class=" "
            scrollY="100%"
            idDivPaginate="bass-right"
            idDivInfo="bas-left"
            name="myDataTable" url="{{ url('/achat/tronc_data/'.$achat->id) }}" :columns="$getTitle()"
            afterLoadFunction="afterLoadAchatTronc"
            pagingType="full"

        />
    </div>
    <div class="d-flex justify-content-between align-items-center  flex-wrap-sm border">
        <div id='bas-left' class="ml-2" style="order:1;">
        </div>

        <div id="bass-right" class="mr-2 d-flex" style="order:3;">

        </div>
    </div>

</div>

@push("script0")
<script>
    $(function(){
        if(!$.AfterLoadDataTable){
            $.AfterLoadDataTable={};
        }

        $.AfterLoadDataTable.afterLoadAchatTronc=function (json){
            console.log(json);
            $('#total_tronc_info').html(json.total_kg);
            $('#total_poids_info').html(json.total);
        }
    })

     </script>
@endpush


@push("script")
<script>
    $(function(){

        function context_add(){
            $("#achat_form_content").addClass('bg-success');
            $("#achat_form_content").removeClass('bg-dark');
            $("#tronc_id").val(0);
            $("#poids_tronc").val(0);
            $("#bois_tronc").val();
            $('#numero_tronc').html("---");
        }

        $("#add_tronc_achat").on('success',function(e,response){
            if(response.status){
                $('#poids_tronc').val(0);
                context_add();
                $('#numero_tronc').html(response.identifiant);

                let dataTable=$("#myDataTable").DataTable();

                dataTable.ajax.reload();
                $("#poids_tronc").select();

            }


        });


    })

     </script>
@endpush


@push('script2')
<script>
    $(function(){

        function context_update(data){
            $("#achat_form_content").removeClass('bg-success');
            $("#achat_form_content").addClass('bg-dark');
            $("#tronc_id").val(data.id);
            $("#poids_tronc").val(data.poids);
            $("#bois_tronc").val(data.bois_id);
            $('#numero_tronc').html(data.identifiant);
            $("#poids_tronc").select();

        }



        let dataTable=$("#myDataTable").DataTable();
        //dataTable.order.fixed( { pre: [ 3, 'desc' ]} );

        dataTable.on('draw.dt',function(){
            $(".update_tronc").on('click',function(e){

                let data=$(this).data('info');
                console.log(data);
                context_update(data);

            });
        });
    });
</script>
@endpush
