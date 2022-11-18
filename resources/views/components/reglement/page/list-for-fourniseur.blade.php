@extends('npl::layouts.ly-list')

@section('ly-toolbar')
    <x-npl::tool-bar.bar class="ml-1">
        <x-npl::tool-bar.link id="last_reglement_tb" text="Derniére reglement" :url="url('reglement/fournisseur/'.$fournisseur->id)" evidence="btn-primary" class="ml-2" />
        <x-npl::tool-bar.divider/>
        <x-npl::tool-bar.link id="tous_reglement_tb" text="Fournisseurs"   :url="url('reglement')"  />
    </x-npl::tool-bar.bar>
@endsection


@section('ly-alert')
<div class="" id="addreglementAlert" style="position: sticky;top:43px;border-radius:0px;"></div>
@endsection

@section('ly-title')
<x-npl::title-bar.bar>
    <x-slot name="image">
        <x-npl::icon.simple name="point_of_sale" taille="40"/>
    </x-slot>
    <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('reglement/') }}">Fournisseur</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{ucfirst($fournisseur->nom)}}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>
    <x-slot name="right">
        <div class="mr-2">
            <x-npl::infos.info-list >
            @if($lastreglement->etat)
                <x-npl::infos.info-item title="Etat Compte" value="{{number_format($lastreglement->last,0,'',' ')}} FCFA" icon="payments" typeIcon="material-icons-outlined" id_value="somme_total_info" />
            @else
                <x-npl::infos.info-item title="Etat Compte" value="{{number_format($lastreglement->total(),0,'',' ')}} FCFA" icon="payments" typeIcon="material-icons-outlined" id_value="somme_total_info" />
            @endif
        </x-npl::infos.info-list>
        </div>
    </x-slot>
</x-npl::title-bar.bar>
@endsection


@section('ly-main-content')
    <x-reglement.util.list-for-fourniseur :fournisseur="$fournisseur" />
@endsection

@section('ly-main-bot')

        <div class="d-flex justify-content-between align-items-center  flex-wrap-sm border">
            <div id='bas-left' class="ml-2" style="order:1;">
            </div>
            <span id="total-montant" class="bas-entre" style="order: 2;"></span>

            <div id="bass-right" class="mr-2 d-flex" style="order:3;">

            </div>
        </div>


@endsection

@once
    @push('script')
        <script type="text/javascript">

        </script>
    @endpush
@endonce
@push("script0")
<script>


</script>
@endpush
