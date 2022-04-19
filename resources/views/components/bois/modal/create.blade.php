<x-generic.modal.simple id="modal_bois_form" :titre="$titreModal" :url="url('bois_save')" idForm="form_bois_form" class="">

    <div class="">
        <x-generic.forms.form-table class="form-table-none">
            <x-generic.forms.form-table-text name="Nom" labelText="Nom" disposition="block" :value="$bois->nom"
                    required="true"  placeholder="ex:djibouti,fraké" id="nom"  />

            <x-generic.forms.form-table-text name="prix_tronc" labelText="Prix Tonc" :value="$bois->prix_tronc" disposition="block"
                    required="true" placeholder="" id="prix_tronc" typpe="number"/>

            <x-generic.forms.form-table-text name="prix_planche" labelText="Prix Planche" :value="$bois->prix_planche" disposition="block"
                        required="true" placeholder="" id="prix_planche" typpe="number"/>


        </x-generic.forms.form-table>

    </div>




    <x-slot name="actions">

    </x-slot>
</x-generic.modal.simple>

@stack('script')
<script>
    $(function(){
        $('#form_bois_form').on('success',function(e){
            $(this)[0].reset();
        });
    });
</script>

