<x-npl::modal.simple id="modal_new_type_depense" titre="Nouveau Groupe depense" :url="url('param-compte/type_depense')" idForm="form_new_type_depense" class="">

    <div class="">
    <input type="hidden" name="type_depense_id"  id="type_depense_id_md">
    <x-npl::forms.form-table class="form-table-none">

        <x-npl::forms.form-table-text  name="nom"  labelText="Nom :" value=""
                required="true" placeholder="nom"  id="nom_md"
                 disposition="block" />
        <x-npl::forms.form-table-text  name="seuil"  labelText="Seuil :" value=""
                required="true" placeholder="seuil"  id="seuil_md"
                disposition="block" />



    </x-npl::forms.form-table >
    </div>
    <x-slot name="actions">

    </x-slot>

</x-npl::modal.simple>

@push('script')
<script>
    $(function(){

        $('#form_new_type_depense').on('success',function(e,response){
            @if($attributes['dataTableId'])
                    let dataTable=$("#{{$attributes['dataTableId']}}").DataTable();
                dataTable.ajax.reload();
            @endif
        });
    });
</script>
@endpush
