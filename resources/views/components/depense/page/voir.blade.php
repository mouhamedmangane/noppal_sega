@extends('npl::layouts.ly')
@section('ly-toolbar')
<x-npl::tool-bar.bar >

   <x-npl::tool-bar.prev-button id="prev_tb"  url="/depense/"  />

    <x-npl::tool-bar.link id="nouveau_depense_tb" text="Nouveau" icon="add" url="/depense/create" evidence="btn-primary" :canAccess="['depense_bois',['c']]" />
    @if($depense->updatable)
        <x-npl::tool-bar.link id="modifier_depense_tb" text="Modifier" icon="edit" :url="url('depense/'.$depense->id.'/edit')" :canAccess="['depense_bois',['u']]" />
        <x-npl::tool-bar.button id="supprimer_depense_tb" text="Supprimer" icon="delete"  disabled="disabled" :canAccess="['depense_bois',['d']]" />
    @endif


</x-npl::tool-bar.bar >
@endsection
@section('ly-title')
<div class="d-flex align-items-center justify-content-between px-4  px-sm-0 mt-1">

    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="point_of_sale" taille="40" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('depense/') }}">Depenses</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{$depense->numero()}}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>


        <x-slot name="right">
            <div class="mr-4 m-sm-0 mx-sm-0 overflow-x-sm-auto">
                <x-npl::infos.info-list>
                    <x-npl::infos.info-item title="Total / Seuil Mois" :value="$infos['seuil'].' FCFA'" icon="assignment_turned_in"  :couleur="$couleur_infos['seuil']" id_value="total_seuil_info"/>
                    <x-npl::infos.info-item title="crée le" :value="$depense->created_at->format('d-m-Y')" icon="assignment_turned_in"  id_value="creer_le_info"/>
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar >
</div>
@endsection

@section('ly-alert')
<div class="" id="addDepenseAlert" style="position: sticky;top:43px;border-radius:0px;"></div>
@endsection




@section('ly-main-content')
    <x-depense.util.voir :model="$depense" />
@endsection

@section('ly-main-bot')
       <div class="col-md-6">

       </div>
@endsection




{{-- alert montant ou poids null --}}
@push('script')
<script>
    $(function(){


    });
</script>

@endpush

@push("script")
    <script>

    </script>
@endpush




