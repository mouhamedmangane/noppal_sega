@extends('npl::layouts.ly')
@section('ly-toolbar')
    <x-npl::tool-bar.bar>
        <x-npl::tool-bar.prev-button id="prev_tb" :url="url('planche')"/>
        <x-npl::input.button-submit id="submit_produit_tb"
                                    idForm="create_planche_form"
                                    idContentAlert="listplancheAlert"
                                    class="tb-btn btn btn-primary btn-sm d-flex align-items-center mr-3"
                                    text="Enregistrer"
                                    hrefId="planche"
                                    parentMessageClass=""
                                    elementMessageClass=""
                                    :isReset="false"
                                    icon="save"/>
        {{-- @if(isset($planche->id))
            @if(empty($planche->archived))
                @props(['icon_archiver'=>'archive','text_archiver'=>'Archiver','url_archiver'=>'planche/archiver/'])
            @else
                @props(['icon_archiver'=>'unarchive','text_archiver'=>'Désarchiver','url_archiver'=>'planche/desarchiver/'])
            @endif
            <x-npl::tool-bar.ajax id="archiver_planche_tb" :icon="$icon_archiver"  :text="$text_archiver"
            :url="url($url_archiver.$planche->id)" method="get"
            :redirect="'planche/'.$planche->id" idAlert="listplancheAlert" />
        @endif --}}

        <x-npl::tool-bar.divider/>

        <x-npl::tool-bar.link id="person_add" icon="person_add" url="/planche/create" text="Nouveau Planche"  />

    </x-npl::tool.bar.bar>
@endsection

@section('ly-alert')
    <x-npl::alert.bar id='listplancheAlert' />
@endsection

@section('ly-title')
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="person" taille="16" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('planche') }}">Planche</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{ (isset($planche->id)    )?$planche->m3.' m3':'Nouveau Planche' }}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>

        <x-slot name="right">
            <div class="mr-4">
                <x-npl::infos.info-list >

                    @if(isset($planche->id))
                        <x-npl::infos.info-item title="Statut" :value="$statusInfo" icon="assignment_turned_in" :couleur="$couleurInfo" />

                    @endif
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar>
@endsection

@section('ly-main-content')
        <x-planche.util.create  :model="$planche" />

@endsection
