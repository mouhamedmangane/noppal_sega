@section("ly-main-top")
<div class="pl-3 d-flex py-2 align-items-center" style="overflow-x:auto;white-space:nowrap;height: 100%; ">
    <span class="px-3 " >
        <span>
            Paiement :
            <span class="btn btn-sm btn-success text-lg ml-2" style="border-radius: 20px;word-break:break-all">
                <span id="total_somme_info">{{number_format($reglement->totalSomme(),0,'',' ')}}</span> FCFA
            </span>
        </span>
    </span>
    <span class="px-3 " >
        <span>
            Chargement :
            <span class="btn btn-sm btn-primary text-lg ml-2" style="border-radius: 20px;word-break:break-all">
                <span id="total_achat_info">{{number_format($reglement->totalAchat(),0,'',' ')}}</span> FCFA
            </span>
        </span>
    </span>
</div>


@endsection


<x-npl::data-table.simple class="" name="myDataTable2"
                            :url="url('reglement/lignes/data/'.$reglement->id)"
                            :columns="$titleTable()" dom="t"
                            scrollY='100%'/>
@push('script2')
<script>
$(function(){

    function updateInfo(reponse){
        $("#somme_total_info").html(reponse.somme);
        $("#last_info").html(reponse.last);
        $("#etat_info").html(reponse.etat);
        if(reponse.last>0){
            $("#somme_total_info").css('color','var(--green);')
        }
        else if(reponse.last<0){
            $("#somme_total_info").css('color','var(--red);')
        }

    }

    var table = $('#myDataTable2').DataTable();
    table.on('draw.dt',function(){
        $('.btn-edit-paiement').off();
        $('.btn-edit-paiement').on('click',function(){
                $('#paiement_id_md').val($(this).data('id'));
                $('#somme_md').val($(this).data('somme'));
                $('#modal_new_ligne_paiement').modal('show');

            });
        $('.btn-delete-paiement').off();
        $('.btn-delete-paiement').on('click',function(){
        if(confirm("Etes vous sure de vouloir supprimer ce paiement")){
            let id=$(this).data('id');
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('reglement/ligne/paiement/delete') }}",
                type: "delete",
                data:{
                    'id':id
                },
                dataType: "json",
                success: function (response) {
                    if(response.status){
                        $.fn.nplAlertBarShow('#addreglementAlert',response.message,"alert alert-success","alert alert-danger",1);
                        let dataTable=$("#myDataTable2").DataTable();
                        dataTable.ajax.reload();
                        updateInfo(response);
                    }
                    else{
                        $.fn.nplAlertBarShow('#addreglementAlert',response.message,"alert alert-danger","alert alert-success",0);
                    }
                },
                error: async function (err){
                    $.fn.nplAlertBarShow('#addreglementAlert',response.message,"alert alert-danger","alert alert-success",1);

                }
            });
        }


        });

        $('.btn-delete-achat').off();
        $('.btn-delete-achat').on('click',function(){
        if(confirm("Etes vous sure de vouloir supprimer ce paiement")){
             let id=$(this).data('id');
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('achat') }}/"+id,
            type: "delete",
            data:{
                'id':id
            },
            dataType: "json",
            success: function (response) {
                if(response.status){
                    $.fn.nplAlertBarShow('#addreglementAlert',response.message,"alert alert-success","alert alert-danger",1);
                    let dataTable=$("#myDataTable2").DataTable();
                    dataTable.ajax.reload();
                    updateInfo(response);
                }
                else{
                    $.fn.nplAlertBarShow('#addreglementAlert',response.message,"alert alert-danger","alert alert-success",0);
                }
            },
            error: async function (err){
                $.fn.nplAlertBarShow('#addreglementAlert',response.message,"alert alert-danger","alert alert-success",1);

            }
        });
        }


        });


    });


});

</script>
@endpush

