<x-npl::modal.simple id="modal_new_ligne_paiement" titre="Nouveau ligne Paiement" :url="url('vente/paiement')" idForm="form_new_ligne_paiement" class="">

    <div class="">
    <input type="hidden" name="vente_id" value="{{$vente->id}}" id="vente_id_md">
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
        function updateInfo(montant,etat){
            $("#montant_restant_info").html(montant);
            $("#etat_vente_info").html(etat);
            if(etat=="commande"){
                $("#etat_vente_info").css('color','var(--danger);')
            }else if(etat=="accompte"){
                $("#etat_vente_info").css('color','var(--warning);')
            }
            else if(etat=="complete"){
                $("#etat_vente_info").css('color','var(--success);')
            }

        }
        $('#form_new_ligne_paiement').on('success',function(e,response){
            $('#paiement_id_md').val(0);
            $('#somme_md').val(0);
            let dataTable=$("#{{$dataTableId}}").DataTable();
            dataTable.ajax.reload();
            updateInfo(response.montant_restant,response.etat);

        });
    });
</script>
@endpush
