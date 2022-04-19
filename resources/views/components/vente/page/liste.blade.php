@extends('npl::layouts.ly-list')

@section('ly-toolbar')
    <x-npl::tool-bar.bar class="ml-1">
        @if(\App\Util\Access::canAccess('vente_bois',['r']))
        <x-npl::tool-bar.link id="nouveau_vente_tb" text="Nouveau" icon="add" url="/vente/create" evidence="btn-primary" class="ml-2" />
        @endif

        <x-npl::tool-bar.button id="modifier_vente_tb" text="Modifier" icon="edit" disabled="disabled" :canAccess="['vente_bois',['u']]" />
        <x-npl::tool-bar.button id="supprimer_vente_tb" text="Supprimer" icon="delete"  disabled="disabled" :canAccess="['vente_bois',['d']]" />
        <x-npl::tool-bar.divider/>
        <x-npl::filters.filter :filter="$getFilter()"/>

        <x-npl::data-table.group-by-btn id="groupby_prod_tb"  label="Grouper Par" idDataTable="myDataTable"
                                           :dt="['etat'=>'Etat','date'=>'date']" defaultSelected=''  />


    </x-npl::tool-bar.bar>
@endsection


@section('ly-alert')
<div class="" id="addVenteAlert" style="position: sticky;top:43px;border-radius:0px;"></div>
@endsection

@section('ly-title')
<x-npl::title-bar.bar>
    <x-slot name="image">
        <x-npl::icon.simple name="point_of_sale" taille="40"/>
    </x-slot>
    <x-npl::links.select-link-dt idDataTable="myDataTable" value="tous"
                                :dt="[
                                    url('vente/data')=>'Vente Aujourdui',
                                    url('vente/data/accompte')=>'Ventes Accompte',
                                    url('vente/data/commande')=>'Ventes Commnade',
                                    url('vente/data/paye_non_livre')=>'Ventes Payé Non Livré',
                                    url('vente/data/all')=>'Toutes les ventes',
                                ]"
                                class="mx-2" />
    <x-slot name="right">
        <x-npl::filters.search-filter id='mySearch' name="tous" dataTableId="myDataTable" />
    </x-slot>
</x-npl::title-bar.bar>
@endsection


@section('ly-main-content')
    <x-vente.util.liste />
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
    $(function(){
        if(!$.AfterLoadDataTable){
            $.AfterLoadDataTable={};
        }

        $.AfterLoadDataTable.afterLoadVente=function (json){
            $('#total-montant').html(json.somme+' FCFA');
        }
    })

     </script>
@endpush
