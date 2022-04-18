@extends('npl::layouts.ly-list')

@section("ly-toolbar")
    <x-npl::tool-bar.bar>
        <x-npl::tool-bar.button-modal id="nouveau_type_depense_tb" text="Nouveau" icon="add" target="modal_new_type_depense"  evidence="btn-primary"  />

        <x-npl::tool-bar.button id="modifier_type_depense_tb" icon="edit" text="Modifier"/>
        <x-npl::tool-bar.button id="supprimer_type_depense_tb" icon="delete" text="Supprimer" />
        <x-npl::tool-bar.button id="archiver_type_depense_tb" icon="archive" text="Archiver"/>
        <x-npl::tool-bar.button id="desarchiver_type_depense_tb" icon="unarchive" text="Déarchiver"/>
    </x-npl::tool-bar.bar>
@endsection

@section("ly-title")
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="group" taille="16"/>
        </x-slot>
        <x-npl::links.select-link-dt idDataTable="myDataTable" value="tous"
                                    :dt="[
                                        url('param-compte/type_depense/data')=>'Liste des Groupes Depenses',
                                        url('param-compte/type_depense/data/archiver')=>'Liste des Utilisateurs Groupes Depenses',
                                    ]"
                                    class="mx-2" />
        <x-slot name="right">
            <x-npl::filters.search-filter id='mySearch' name="tous" dataTableId="myDataTable" />
        </x-slot>
    </x-npl::title-bar.bar>
@endsection


@section('ly-main-content')
    <x-type-depense.util.liste  />
@endsection

@push('modal')
    <x-type-depense.modal.create  dataTableId="myDataTable"/>

@endpush


@push('script')
<script>
    $(function(){
        $("#modifier_type_depense_tb").on('click_for_dt',function(e,selecteds){
            console.log(selecteds);
            if(selecteds.length>0){

                $('#type_depense_id_md').val(selecteds);
                $('#nom_md').val(selecteds);
                $("#modal_new_type_depense").modal('show');
            }

        });

        $('#nouveau_type_depense_tb').on('click',function(){
            $('#type_depense_id_md').val("");
            $('#nom_md').val("");
        });
    });
</script>

@endpush
