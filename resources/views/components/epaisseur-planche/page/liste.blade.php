@extends('npl::layouts.ly-list')

@section("ly-toolbar")
    <x-npl::tool-bar.bar>
        <x-npl::tool-bar.button-modal id="nouveau_epaisseur_planche_tb" icon="add" text="Nouveau" target="modal_new_epaisseur"  evidence="btn-primary"/>

        <x-npl::tool-bar.button id="modifier_epaisseur_planche_tb" icon="edit" text="Modifier"/>
        <x-npl::tool-bar.button id="supprimer_epaisseur_planche_tb" icon="delete" text="Supprimer" />
        <x-npl::tool-bar.button id="archiver_epaisseur_planche_tb" icon="archive" text="Archiver"/>
        <x-npl::tool-bar.button id="desarchiver_epaisseur_planche_tb" icon="unarchive" text="Déarchiver"/>

    </x-npl::tool-bar.bar>
@endsection

@section("ly-title")
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="gavel" taille="16"/>
        </x-slot>
        <x-npl::links.select-link-dt idDataTable="myDataTable" value="tous"
                                    :dt="[
                                        url('epaisseur_planche/data')=>'Epaisseurs planches',
                                        url('epaisseur_planche/data/archiver')=>'Epaisseurs planches Archivées',
                                    ]"
                                    class="mx-2" />
        <x-slot name="right">
            <x-npl::filters.search-filter id='mySearch' name="tous" dataTableId="myDataTable" />
        </x-slot>
    </x-npl::title-bar.bar>
@endsection


@section('ly-main-content')
    <x-epaisseur-planche.util.liste />
@endsection


@push('modal')
    <x-epaisseur-planche.modal.create :model="$epaisseur" idDataTable="myDataTable" />
@endpush


@push('script')
<script>
    $(function(){
        $('#modifier_epaisseur_planche_tb').on('click',function(){
            let selectedId=$('#myDataTable .dataTable-simple-selectItem').serializeObject();
            selectedId=selectedId['epaisseur_planche_select[]'];
            if(selectedId){
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('epaisseur_planche/get') }}",
                    type: "post",
                    data:{
                        id:selectedId
                    },
                    dataType: "json",
                    success: function (response) {


                        if(response.status){
                           $('#id_md').val(response.data.id);
                           $('#id_new_md').val(response.data.id);
                           $('#nom_new_md').val(response.data.nom);
                           $('#modal_new_epaisseur').modal('show');
                        }
                        else{
                            alert(response.message);
                        }
                    },
                    error: async function (err){
                        alert("Impossible de joindre le serveur")
                    }
                });
            }
        });
    });
</script>

@endpush
