@extends('npl::layouts.ly-list')

@section("ly-toolbar")
    <x-npl::tool-bar.bar>
        <x-npl::tool-bar.link id="nouveau_planche_tb" icon="add" text="Nouveau" url="{{ url('planche/create') }}" :canAccess="['planche',['c']]"  evidence="btn-primary"  class="ml-2" />

        <x-npl::tool-bar.button id="modifier_planche_tb" icon="edit" text="Modifier" :canAccess="['planche',['u']]" />
        <x-npl::tool-bar.button id="supprimer_planche_tb" icon="delete" text="Supprimer" :canAccess="['planche',['d']]" />
        {{-- <x-npl::tool-bar.button id="archiver_planche_tb" icon="archive" text="Archiver"/>
        <x-npl::tool-bar.button id="desarchiver_planche_tb" icon="unarchive" text="Déarchiver"/> --}}

    </x-npl::tool-bar.bar>
@endsection

@section("ly-title")
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="gavel" taille="16"/>
        </x-slot>
        <x-npl::links.select-link-dt idDataTable="myDataTable" value="tous"
                                    :dt="[
                                        url('planche/data')=>'Liste des planches',
                                        url('planche/data/archiver')=>'Liste des planches Archivées',
                                    ]"
                                    class="mx-2" />
        <x-slot name="right">
            <x-npl::filters.search-filter id='mySearch' name="tous" dataTableId="myDataTable" />
        </x-slot>
    </x-npl::title-bar.bar>
@endsection


@section('ly-main-content')
    <x-planche.util.liste />
@endsection
