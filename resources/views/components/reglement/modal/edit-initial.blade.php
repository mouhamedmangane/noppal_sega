<x-npl::modal.simple id="modal_edit_initial" titre="Modification du Montant Initial du Reglement" :url="url('reglement/'.$model->id.'/edit_initial')" idForm="form_edit_initial" class="">

    <div class="">
    <input type="hidden" name="reglement_id" value="{{$model->id}}" id="reglement_id_md">
    <x-npl::forms.form-table class="form-table-none">

        <x-npl::forms.form-table-text  name="somme"  labelText="Somme :" :value="$model->initial"
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
            $("#initial_info").html(reponse.initial);
            $("#last_info").html(reponse.last);
            $("#etat_info").html(reponse.etat);
            if(reponse.last>=0){
                $("#last_info").css('color','var(--green);')
            }
            else {
                $("#last_info").css('color','var(--red);')
            }
        }
        $('#modal_edit_initial').on('success',function(e,response){
            $('#somme_md').val(response.initial);
            updateInfo(response);

        });
    });
</script>
@endpush
