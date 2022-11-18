@extends('npl::layouts.ly-list')

@section('ly-toolbar')
    <x-npl::tool-bar.bar >
        @if(\App\Util\Access::canAccess('achat_bois',['r']))
        <x-npl::tool-bar.link id="nouveau_achat_tb" text="Nouveau" icon="add" url="/achat/create" evidence="btn-primary"  class="ml-2"  />
        @endif

        <x-npl::tool-bar.divider/>

    </x-npl::tool-bar.bar>
@endsection


@section('ly-alert')
<div class="" id="addAchatAlert" style="position: sticky;top:43px;border-radius:0px;"></div>
@endsection

@section('ly-title')
<x-npl::title-bar.bar>
    <x-slot name="image">
        <x-npl::icon.simple name="point_of_sale" taille="40"/>
    </x-slot>
    <x-npl::links.select-link-dt idDataTable="myDataTable" value="tous"
                                :dt="[
                                    url('fournisseur/data')=>'Mes Fournisseurs',
                                    
                                ]"
                                class="mx-2" />
    <x-slot name="right">
        <x-npl::filters.search-filter id='mySearch' name="tous" dataTableId="myDataTable" />
    </x-slot>
</x-npl::title-bar.bar>
@endsection


@section('ly-main-content')
    <x-fournisseur.util.liste />
@endsection

@section('ly-main-bot')

        <div class="d-flex justify-content-between align-items-center  border">
            <div id='bas-left' class="ml-2">
            </div>
            <span id="total-montant"></span>

            <div id="bass-right" class="mr-2 d-flex">

            </div>
        </div>


@endsection


