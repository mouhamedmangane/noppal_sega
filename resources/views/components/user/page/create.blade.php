@extends('npl::layouts.ly')
@section('ly-toolbar')
    <x-npl::tool-bar.bar>
        <x-npl::tool-bar.prev-button id="prev_tb" :url="url('param-compte/users')"/>
        <x-npl::input.button-submit id="submit_produit_tb"
                                       idForm="create_user_form"
                                       idContentAlert="listUserAlert"
                                       class="tb-btn btn btn-primary btn-sm d-flex align-items-center mr-3"
                                       text="Enregistrer"
                                       hrefId="param-compte/users"
                                       parentMessageClass=""
                                       elementMessageClass=""
                                       :isReset="false"
                                       icon="save"/>
        @if(isset($user->id))
            @if(empty($user->archiver))
                @props(['icon_archiver'=>'archive','text_archiver'=>'Archiver','url_archiver'=>'param-compte/users/archiver/'])
            @else
                @props(['icon_archiver'=>'unarchive','text_archiver'=>'Désarchiver','url_archiver'=>'param-compte/users/desarchiver/'])
            @endif
            <x-npl::tool-bar.ajax id="archiver_user_tb" :icon="$icon_archiver"  :text="$text_archiver"
            :url="url($url_archiver.$user->id)" method="get"
            :redirect="'param-compte/users/'.$user->id" idAlert="listUserAlert" />
        @endif

        <x-npl::tool-bar.divider/>

        <x-npl::tool-bar.link id="person_add" icon="person_add" url="/param-compte/users/create" text="Nouveau Utilisateur"  />

    </x-npl::tool.bar.bar>
@endsection

@section('ly-alert')
    <x-npl::alert.bar id='listUserAlert' />
@endsection

@section('ly-title')
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="person" taille="16" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('param-compte/users') }}">Utilisateurs</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{ (isset($user->id)    )?$user->name:'Nouveau Utilisateur' }}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>

        <x-slot name="right">
            <div class="mr-4">
                <x-npl::infos.info-list >

                    @if(isset($user))
                        <x-npl::infos.info-item title="Statut" :value="$statusUser" icon="assignment_turned_in" :couleur="$couleurUser" />

                    @endif
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar>
@endsection

@section('ly-main-content')
    <x-user.util.create  :user="$user" />
@endsection
