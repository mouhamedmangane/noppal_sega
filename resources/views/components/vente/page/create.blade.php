@once
    @push('header')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugin/select2-4.1.0-rc.0/dist/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugin/select2-4.1.0-rc.0/dist/css/select2-bootstrap.min.css') }}">
    @endpush
@endonce

@extends('npl::layouts.ly-sans')
@section('ly-toolbar')
    <x-npl::tool-bar.bar >
        @if($vente->id)
            <x-npl::tool-bar.prev-button id="prev_tb"  :url="url('vente/'.$vente->id)"  />
        @else
            <x-npl::tool-bar.prev-button id="prev_tb"  url="/vente/"  />
        @endif
        <x-npl::input.button-submit  id="test-button-submit"
                                        idForm="addVente"
                                        idContentAlert="addVenteAlert"
                                        class="btn btn-primary btn-sm d-flex align-items-center mr-3 "
                                        text="Enregistrer"
                                        hrefId="vente"
                                        parentMessageClass="n-form-table-col-input"
                                        elementMessageClass="form-table-feedback"
                                        icon="save"/>
        <x-npl::tool-bar.button id="" text="Annuler" icon="clear" evidence=""  />

    </x-npl::tool-bar.bar >
@endsection


@section('ly-alert')
    <div class="" id="addVenteAlert" style="position: sticky;top:43px;border-radius:0px;"></div>
@endsection

@section('ly-title')
<x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="add_shopping_cart" taille="16" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('vente') }}">Vente</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{ (isset($vente->id)    )?'VS-'.$vente->id:'Nouvelle Vente' }}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>

        <x-slot name="right">
            <div class="mr-4">
                <x-npl::infos.info-list>
                    <x-npl::infos.info-item title="Montant TOTAL" value="0 FCFA" icon="assignment_turned_in" couleur="success" id_value="m_total"/>
                    <x-npl::infos.info-item title="Nombre Kg" :value="$vente->sumKg().' Kg'" icon="assignment_turned_in" couleur="danger" id_value="m_total_kg"/>
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar>
@endsection



@section('ly-main-content')
    <x-vente.util.create :model="$vente"/>
@endsection

@section('ly-main-bot')



@endsection

@once
    @push('script')
        <script type="text/javascript">

        </script>
    @endpush
@endonce
