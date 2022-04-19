<x-npl::modal.simple id="modal_change_photo" titre="Changer Photo Profil" :url="url('photo_save')" idForm="form_change_photo" class="" enctype="multipart/form-data">
    @php
        $path='images/users/'.Auth::user()->photo;
        if(!file_exists(public_path($path)))
            $path='images/profig.jpg';
    @endphp
    <div class="d-flex justify-content-center my-3 flex-wrap">
        <x-npl::input.photo :url="URL::asset($path)"  name="photo"
                                x="150" y="150" circle="true"
                                id="photo_profil" idTriggerEdit="tigger_edit_photo_profil"
                                activeText="false" />
        <div class="text my-2 col-md-12 text-center">
            Cliquer sur le button modifier phofil pour changer la photo

        </div>
        <div class="col-md-12">
            <div class="my-2 text-center">
                <button type="button" id="tigger_edit_photo_profil" class="btn btn-light text-primary">Modifier Photo</button>
            </div>
        </div>

    </div>




    <x-slot name="actions">

    </x-slot>
</x-npl::modal.simple>

@stack('script')
<script>
    $(function(){
        $('#modal_change_photo').on('success',function(e){
            $('#photo_profil').updateProfilImage('.n__profil_user_class');
        });
    });
</script>
