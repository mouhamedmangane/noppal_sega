@extends('npl::layouts.ly-list')


@section("ly-toolbar")
    <x-npl::tool-bar.bar>
        <x-npl::tool-bar.link id="nouveau_role_tb" icon="add" text="Nouveau" url="{{ url('param-compte/roles/create') }}"  evidence="btn-primary"  class="ml-2" />
        <x-npl::tool-bar.button id="modifier_role_tb" icon="edit" text="Modifier"/>
        <x-npl::tool-bar.button id="supprimer_role_tb" icon="delete" text="Supprimer" />
    </x-npl::tool-bar.bar>
@endsection

@section("ly-title")
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="gavel" taille="16"/>
        </x-slot>
        <x-npl::links.select-link-dt idDataTable="myDataTable" value="tous"
                                    :dt="[
                                        url('param-compte/roles/data')=>'Liste des Roles',
                                        url('param-compte/roles/data/archiver')=>'Liste des Roles Archivées',
                                    ]"
                                    class="mx-2" />
        <x-slot name="right">
            <x-npl::filters.search-filter id='mySearch' name="tous" dataTableId="myDataTable" />
        </x-slot>
    </x-npl::title-bar.bar>
@endsection


@section('ly-main-content')
    <x-role.util.liste :roles="$roles" />
@endsection
