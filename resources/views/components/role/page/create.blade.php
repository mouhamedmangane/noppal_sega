@extends('npl::layouts.ly-sans')
@section('ly-toolbar')
    <x-npl::tool-bar.bar>
        <x-npl::tool-bar.prev-button id="prev_tb" url="{{ url('param-compte/roles') }}"/>
        <x-npl::input.button-submit id="submit_produit_tb"
                                       idForm="create_user_form"
                                       idContentAlert="listRoleAlert"
                                       class="btn btn-primary btn-sm d-flex align-items-center mr-3"
                                       text="Enregistrer"
                                       activeMessage="true"
                                       hrefId="param-compte/roles"
                                       activeOnModify="true"
                                       :isReset="false"
                                       icon="save"/>
         @if($role->id)
            @if(empty($role->archiver))
                @props(['icon_archiver'=>'archive','text_archiver'=>'Archiver','url_archiver'=>'param-compte/roles/archiver/'])
            @else
                @props(['icon_archiver'=>'unarchive','text_archiver'=>'Désarchiver','url_archiver'=>'param-compte/roles/desarchiver/'])
            @endif
            <x-npl::tool-bar.ajax id="archiver_user_tb" :icon="$icon_archiver"  :text="$text_archiver"
            :url="url($url_archiver.$role->id)" method="get"
            :redirect="'param-compte/roles/'.$role->id" idAlert="listUserAlert" />
            <x-npl::tool-bar.ajax id="supp_role" icon="delete_forever"  text="supprimer"
                                     :url="url('param-compte/roles/'.$role->id)" method="DELETE"
                                     redirect="param-compte/roles" idAlert="listRoleAlert" />
            <x-npl::tool-bar.divider/>
            <x-npl::tool-bar.link id="add_role" icon="add" url="{{ url('param-compte/roles/create') }}" text="Nouveau Role"  />
        @endif

    </x-npl::tool.bar.bar>
@endsection

@section('ly-alert')
    <x-npl::alert.bar id='listRoleAlert' />
@endsection

@section('ly-title')
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="gavel" taille="16" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('param-compte/roles') }}">Roles</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{ ($role->id)?$role->nom:'Nouveau Role' }}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>


        <x-slot name="right">
            <div class="mr-4">
                <x-npl::infos.info-list >

                    @if($role)
                        <x-npl::infos.info-item title="Nbre d'Utilisateur" :value="$nbrUser" icon="group"  />
                        <x-npl::infos.info-item title="Statut Role" :value="$statusRole" icon="assignment_turned_in" :couleur="$couleurRole" />

                    @endif
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar >
@endsection

@section('ly-main-content')
    <x-role.util.create :role="$role" />
@endsection
