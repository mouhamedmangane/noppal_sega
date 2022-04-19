<x-npl::modal.simple id="modal_new_epaisseur" titre="Nouveau Epaisseur Planche" :url="url('epaisseur_planche')" idForm="form_new_epaisseur" class="">

    <div class="">
    <input type="hidden" name="id" value="{{$epaisseur->id}}" id="id_md">
    <x-npl::forms.form-table class="form-table-none">

        <x-npl::forms.form-table-text  name="id_new"  labelText="Dimension :" :value="$epaisseur->id"
                required="true" placeholder="tigger_edit_epaisseur" typpe="number" id="id_new_md"
                step="0.2" disposition="block" />

        <x-npl::forms.form-table-text  name="nom"  labelText="Nom :" :value="$epaisseur->id"
                required="true" placeholder="ex :  1 trait, 2 trait" disposition="block"  id="nom_new_md"/>

    </x-npl::forms.form-table >
    </div>
    <x-slot name="actions">

    </x-slot>

</x-npl::modal.simple>

@push('script')
<script>
    $(function(){
        $('#form_new_epaisseur').on('success',function(e){
            $('#id_md').val(0);
            $('#id_new_md').val(0);
            $('#nom_new_md').val('');
            let dataTable=$("#{{$idDataTable}}").DataTable();
            dataTable.ajax.reload();
        });
    });
</script>
@endpush
