<x-npl::modal.simple id="modal_profil_form" titre="Modification Profil" :url="url('profil_save')" idForm="form_profil_form" class="">

    <div class="">
        <x-npl::forms.form-table class="form-table-none">
            <x-npl::forms.form-table-text name="old_pwd" labelText="Ancien Mot de passe" disposition="block"
                    required="true"  placeholder="il est obligatoire" id="password" typpe="password" />

            <x-npl::forms.form-table-text name="login" labelText="login" :value="$user->email" disposition="block"
                    required="true" placeholder="Donner le login" id="login"/>

            <x-npl::forms.form-table-text name="pwd" labelText="Mot de passe"  disposition="block"
                    required="false"  placeholder="Creer un mot de passe" id="password" typpe="password" />

            <x-npl::forms.form-table-text name="pwd_confirmation" labelText="Confirmer mot de passe" disposition="block"
                     required="false"  placeholder="Confirmer le mot de passe" id="password-confirm" typpe="password"/>

        </x-npl::forms.form-table>

    </div>




    <x-slot name="actions">

    </x-slot>
</x-npl::modal.simple>

@stack('script')
<script>
    $(function(){
        $('#form_profil_form').on('success',function(e){
            $(this)[0].reset();
        });
    });
</script>
