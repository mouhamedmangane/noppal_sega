<x-npl::modal.simple id="modal_typedepense_form" titre="Modification Typedepense" :url="url('typedepense_save')" idForm="form_typedepense_form" class="">

    <div class="">
        <x-npl::forms.form-table class="form-table-none">
            <x-npl::forms.form-table-text name="nom" labelText="Donner le nom" disposition="block"
                     required="true"  placeholder="Doner le nom" id="password-confirm" />

        </x-npl::forms.form-table>

    </div>




    <x-slot name="actions">

    </x-slot>
</x-npl::modal.simple>

@stack('script')
<script>
    $(function(){
        $('#form_typedepense_form').on('success',function(e){
            let dataTable=$("#myDataTable").dataTable();
            dataTable.ajax.reload();
        });
    });
</script>
