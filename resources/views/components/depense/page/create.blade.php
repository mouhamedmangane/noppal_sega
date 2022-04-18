@extends('npl::layouts.ly')
@section('ly-toolbar')
    <x-npl::tool-bar.bar>
        <x-npl::tool-bar.prev-button id="prev_tb" :url="url('depense')"/>
        <x-npl::input.button-submit id="submit_produit_tb"
                                    idForm="create_depense_form"
                                    idContentAlert="listdepenseAlert"
                                    class="tb-btn btn btn-primary btn-sm d-flex align-items-center mr-3"
                                    text="Enregistrer"
                                    hrefId="depense"
                                    parentMessageClass=""
                                    elementMessageClass=""
                                    :isReset="false"
                                    icon="save"/>


        <x-npl::tool-bar.divider/>

        <x-npl::tool-bar.link id="person_add" icon="person_add" url="/depense/create" text="Nouveau Depense"  />

    </x-npl::tool.bar.bar>
@endsection

@section('ly-alert')
    <x-npl::alert.bar id='listdepenseAlert' />
@endsection

@section('ly-title')
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="person" taille="16" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('depense') }}">Depense</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{ (isset($depense->id)    )?$depense->id:'Nouveau Depense' }}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>

        <x-slot name="right">
            <div class="mr-4">
                <x-npl::infos.info-list >

                    @if(isset($depense->id))
                        <x-npl::infos.info-item title="Total Depense" :value="12" icon="assignment_turned_in" couleur="success" />
                        <x-npl::infos.info-item title="Total Groupe" :value="12" icon="assignment_turned_in" couleur="warning" />

                    @endif
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar>
@endsection

@section('ly-main-content')
        <x-depense.util.create  :model="$depense" />

@endsection
