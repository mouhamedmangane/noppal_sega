@extends('npl::layouts.ly-list')

@section("ly-toolbar")
    <x-npl::tool-bar.bar>
        <x-npl::tool-bar.link id="nouveau_bois_tb" icon="add" text="Nouveau" url="{{ url('bois/create') }}"  evidence="btn-primary"  class="ml-2" />

        <x-npl::tool-bar.button id="modifier_bois_tb" icon="edit" text="Modifier"/>
        <x-npl::tool-bar.button id="supprimer_bois_tb" icon="delete" text="Supprimer" />
        <x-npl::tool-bar.button id="archiver_bois_tb" icon="archive" text="Archiver"/>
        <x-npl::tool-bar.button id="desarchiver_bois_tb" icon="unarchive" text="Déarchiver"/>

    </x-npl::tool-bar.bar>
@endsection

@section("ly-title")
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="gavel" taille="16"/>
        </x-slot>
        <x-npl::links.select-link-dt idDataTable="myDataTable" value="tous"
                                    :dt="[
                                        url('bois/data')=>'Liste des boiss',
                                        url('bois/data/archiver')=>'Liste des boiss Archivées',
                                    ]"
                                    class="mx-2" />
        <x-slot name="right">
            <x-npl::filters.search-filter id='mySearch' name="tous" dataTableId="myDataTable" />
        </x-slot>
    </x-npl::title-bar.bar>
@endsection


@section('ly-main-content')
    <x-bois.util.liste />
@endsection

@section('ly-main-bot')

        <div class="d-flex justify-content-between align-items-center  border">
            <div id='bas-left' class="ml-2">

            </div>
            <div id="bass-right" class="mr-2 d-flex">

            </div>
        </div>


@endsection
