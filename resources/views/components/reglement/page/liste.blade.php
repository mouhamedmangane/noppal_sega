@extends('npl::layouts.ly-list')

@section('ly-toolbar')
    <x-npl::tool-bar.bar class="ml-1">


        <x-npl::tool-bar.link id="ajouter_fournisseur_tb" text="Creer Fournisseur" icon="add" :url='url("contact/createwithretour/reglement/fournisseur")' :canAccess="['vente_bois',['u']]" />
        <x-npl::tool-bar.divider/>
        {{-- <x-npl::filters.filter :filter="$getFilter()"/> --}}

        <x-npl::tool-bar.link id="historique_reglement_tb"  text="Historique Réglement" icon='' :url="url('reglement/historique')"  />


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
                                    url('reglement/data')=>'Tous Les Fournisseurs',
                                    url('reglement/data/rouge')=>'Fournisseur rouge',
                                    url('reglement/data/vert')=>'Fournisseur vert',

                                ]"
                                class="mx-2 custom-select custom-select-sm" />
    <x-slot name="right">
        <x-npl::filters.search-filter id='mySearch' name="tous" dataTableId="myDataTable" />
    </x-slot>
</x-npl::title-bar.bar>
@endsection


@section('ly-main-content')
    <x-reglement.util.liste />
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
