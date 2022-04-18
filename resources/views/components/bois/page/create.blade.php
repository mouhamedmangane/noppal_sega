@extends('npl::layouts.ly')
@section('ly-toolbar')
    <x-npl::tool-bar.bar>
        <x-npl::tool-bar.prev-button id="prev_tb" :url="url('bois')"/>
        <x-npl::input.button-submit id="submit_produit_tb"
                                    idForm="create_bois_form"
                                    idContentAlert="listboisAlert"
                                    class="tb-btn btn btn-primary btn-sm d-flex align-items-center mr-3"
                                    text="Enregistrer"
                                    hrefId="bois"
                                    parentMessageClass=""
                                    elementMessageClass=""
                                    :isReset="false"
                                    icon="save"/>
        @if(isset($bois->id))
            @if(empty($bois->archived))
                @props(['icon_archiver'=>'archive','text_archiver'=>'Archiver','url_archiver'=>'bois/archiver/'])
            @else
                @props(['icon_archiver'=>'unarchive','text_archiver'=>'Désarchiver','url_archiver'=>'bois/desarchiver/'])
            @endif
            <x-npl::tool-bar.ajax id="archiver_bois_tb" :icon="$icon_archiver"  :text="$text_archiver"
            :url="url($url_archiver.$bois->id)" method="get"
            :redirect="'bois/'.$bois->id" idAlert="listboisAlert" />
        @endif

        <x-npl::tool-bar.divider/>

        <x-npl::tool-bar.link id="person_add" icon="person_add" url="/bois/create" text="Nouveau Bois"  />

    </x-npl::tool.bar.bar>
@endsection

@section('ly-alert')
    <x-npl::alert.bar id='listboisAlert' />
@endsection

@section('ly-title')
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="person" taille="16" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('bois') }}">Bois</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{ (isset($bois->id)    )?$bois->name:'Nouveau Bois' }}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>

        <x-slot name="right">
            <div class="mr-4">
                <x-npl::infos.info-list >

                    @if(isset($bois->id))
                        <x-npl::infos.info-item title="Statut" :value="$statusbois" icon="assignment_turned_in" :couleur="$couleurbois" />

                    @endif
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar>
@endsection

@section('ly-main-content')
        <x-bois.util.create  :model="$bois" />

@endsection
