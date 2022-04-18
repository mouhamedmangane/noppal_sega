@extends('npl::layouts.ly-list')

@section("ly-toolbar")
    <x-npl::tool-bar.bar>
        <x-npl::tool-bar.link id="nouveau_contact_tb" icon="add" text="Nouveau" url="{{ url('contact/create') }}"  evidence="btn-primary" :canAccess="['contact',['c']]"  class="ml-2" />
        <x-npl::tool-bar.button id="modifier_contact_tb" icon="edit" text="Modifier" :canAccess="['contact',['u']]" />

        <x-npl::tool-bar.button id="supprimer_contact_tb" icon="delete" text="Supprimer" :canAccess="['contact',['d']]" />
        <x-npl::tool-bar.button id="archiver_contact_tb" icon="archive" text="Archiver" :canAccess="['contact',['u']]" />
        <x-npl::tool-bar.button id="desarchiver_contact_tb" icon="unarchive" text="Déarchiver" :canAccess="['contact',['u']]" />
        <x-npl::filters.filter :filter="$getFilter()"/>
        <x-npl::data-table.group-by-btn id="groupby_contact_tb"  label="Grouper Par" idDataTable="myDataTable"
                                           :dt="['type'=>'type']" defaultSelected=''  />

    </x-npl::tool-bar.bar>
@endsection

@section("ly-title")
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="people" taille="16"/>
        </x-slot>
        <x-npl::links.select-link-dt idDataTable="myDataTable" value="tous"
                                    :dt="[
                                        url('contact/data')=>'Tous les Contacts',
                                        url('contact/data/client')=>'Clients',
                                        url('contact/data/client_dette')=>'Clients Endettés',
                                        url('contact/data/client_credit')=>'Clients Créditeurs',
                                        url('contact/data/fournisseur')=>'Fournisseurs',
                                        url('contact/data/fournisseur_dette')=>'Fournisseur Endettés',
                                        url('contact/data/fournisseur_credit')=>'Fournisseur Créditeurs',
                                        url('contact/data/archiver')=>'Contacts Archivés',
                                    ]"
                                    class="mx-2" />
        <x-slot name="right">
            <x-npl::filters.search-filter id='mySearch' name="tous" dataTableId="myDataTable" />
        </x-slot>
    </x-npl::title-bar.bar>
@endsection


@section('ly-main-content')
    <x-contact.util.liste :liste="$liste" />
@endsection


@section('ly-main-bot')
        <div class="d-flex justify-content-between align-items-center flex-wrap-sm  border">
            <div id='bas-left' class="ml-2 text-center">

            </div>

            <span style="" class=" bas-entre">
            </span>

            <div id="bass-right" class="mr-2 d-flex">

            </div>

        </div>
@endsection
