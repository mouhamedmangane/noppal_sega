@extends('npl::layouts.ly')

@if($vente)
    @props(['url_vente'=>url('vente/'.$vente->id)])
@endif
@section('ly-toolbar')
    <x-npl::tool-bar.bar class="">
        @if($vente)
            <x-npl::tool-bar.prev-button id="prev_tb" :url="$url_vente"/>
            <x-npl::input.button-submit id="submit_produit_tb"
                                       idForm="create_contact_form"
                                       idContentAlert="listContactAlert"
                                       class="btn btn-primary btn-sm d-flex align-items-center mr-3"
                                       text="Enregistrer"
                                       :href="$url_vente"
                                       parentMessageClass=""
                                       elementMessageClass=""
                                       :isReset="false"
                                       icon="save"/>
        @else
            <x-npl::tool-bar.prev-button id="prev_tb" :url="url('contact')"/>
            <x-npl::input.button-submit id="submit_produit_tb"
                                       idForm="create_contact_form"
                                       idContentAlert="listContactAlert"
                                       class="btn btn-primary btn-sm d-flex align-items-center mr-3"
                                       text="Enregistrer"
                                       :hrefId="url('contact')"
                                       parentMessageClass=""
                                       elementMessageClass=""
                                       :isReset="false"
                                       icon="save"/>
        @endif

        @if($contact->id)
            @if(empty($contact->archiver))
                @props(['icon_archiver'=>'archive','text_archiver'=>'Archiver','url_archiver'=>'contact/archiver/'])
            @else
                @props(['icon_archiver'=>'unarchive','text_archiver'=>'Désarchiver','url_archiver'=>'contact/desarchiver/'])
            @endif
            <x-npl::tool-bar.ajax id="archiver_contact_tb" :icon="$icon_archiver"  :text="$text_archiver"
            :url="url($url_archiver.$contact->id)" method="get"
            :redirect="'contact/'.$contact->id" idAlert="listContactAlert" />
        @endif

        <x-npl::tool-bar.divider/>
        @if(!$vente)
        <x-npl::tool-bar.link id="person_add" icon="person_add" :url="url('contact/create')" text="Nouveau Contact"  />
        @endif
    </x-npl::tool.bar.bar>
@endsection

@section('ly-alert')
    <x-npl::alert.bar id='listContactAlert' />
@endsection

@section('ly-title')
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="person" taille="16" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('contact') }}">Contacts</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{ ($contact->id)?$contact->nom:'Nouveau Contact' }}
                @if ($vente)
                    <x-npl::bagde.badge :text="'vent VS-'.$vente->id" class="badge-success" />
                @endif
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>

        <x-slot name="right">
            <div class="mr-4">
                <x-npl::infos.info-list >

                    @if($contact->id)
                        <x-npl::infos.info-item title="Compte" :value="$compte_info" icon="payment" :couleur="$couleurCompte_info" />
                        <x-npl::infos.info-item title="Statut" :value="$status_info" icon="assignment_turned_in" :couleur="$couleur_info" />

                    @endif
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar>
@endsection

@section('ly-main-content')
    <x-contact.util.create  :contact="$contact" :vente="$vente" />
@endsection
