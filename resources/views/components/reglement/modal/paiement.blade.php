<x-npl::modal.simple id="modal_new_ligne_paiement" titre="Nouveau ligne Paiement" :url="url('reglement/ligne/paiement')" idForm="form_new_ligne_paiement" class="">

    <div class="">
    <input type="hidden" name="reglement_id" value="{{$model->id}}" id="vente_id_md">
    <input type="hidden" name="paiement_id" value="" id="paiement_id_md">
    <x-npl::forms.form-table class="form-table-none">

        <x-npl::forms.form-table-text  name="somme"  labelText="Somme :" value=""
                required="true" placeholder="somme" typpe="number" id="somme_md" step='0.01'
                 disposition="block" />



    </x-npl::forms.form-table >
    </div>
    <x-slot name="actions">

    </x-slot>

</x-npl::modal.simple>

@push('script')
<script>
    $(function(){
        function updateInfo(reponse){
            $("#total_somme_info").html(reponse.total_paiement);
            $("#total_achat_info").html(reponse.total_achat);
            $("#initial").html(reponse.initial);
            $("#last_info").html(reponse.last);
            $("#etat_info").html(reponse.etat);
            if(reponse.last>=0){
                $("#last_info").css('color','var(--green);')
            }
            else {
                $("#last_info").css('color','var(--red);')
            }
        }
        $('#form_new_ligne_paiement').on('success',function(e,response){
            $('#paiement_id_md').val(0);
            $('#somme_md').val(0);
            let dataTable=$("#{{$dataTableId}}").DataTable();
            dataTable.ajax.reload();
            updateInfo(response);

        });
    });
</script>
@endpush
