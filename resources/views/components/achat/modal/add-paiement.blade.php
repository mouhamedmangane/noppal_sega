<x-npl::modal.simple id="modal_new_ligne_paiement" titre="Nouveau ligne Paiement" :url="url('achat/paiement')" idForm="form_new_ligne_paiement" class="">

    <div class="">
    <input type="hidden" name="achat_id" value="{{$achat->id}}" id="achat_id_md">
    <input type="hidden" name="paiement_id" value="" id="paiement_id_md">
    <input id="type_depense_modal" type="hidden" name="type_depense" value="paie">
    <input id="data_table_id_md" type="hidden" name="tableID" value="paie">

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
            $('#restant_info').html(new Intl.NumberFormat().format(reponse.restant)+' FCFA');
            $('#restant_info-ls').html(new Intl.NumberFormat().format(reponse.restant)+' FCFA');
            $('#total_paiement_info').html(new Intl.NumberFormat().format(reponse.prix_revient)+' FCFA');
            $('#total_paiement_info-ls').html(new Intl.NumberFormat().format(reponse.total_paiement)+' FCFA');
            $('#paiement-tab .badge').html(new Intl.NumberFormat().format(reponse.nbr_paie));
            $('#frais-tab .badge').html(new Intl.NumberFormat().format(reponse.nbr_frais));
        }
        $('#form_new_ligne_paiement').on('success',function(e,response){
            $('#paiement_id_md').val(0);

            $('#somme_md').val(0);
            let dataTableId=$('#data_table_id_md').val();
            let dataTable=$("#"+dataTableId).DataTable();
            dataTable.ajax.reload();
            updateInfo(response);

        });
    });
</script>
@endpush
