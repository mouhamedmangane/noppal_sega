
@extends('npl::layouts.ly-title')

@section('ly-alert')
    <div class="" id="addAchatAlert" style="position: sticky;top:43px;border-radius:0px;"></div>
@endsection

@section('main')

@section("ly-title")
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="grid_view" taille="40" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('/achat/'.$achat->id) }}">{{$achat->numero()}}</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                    Troncs
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>
        <x-slot name="right">

            <div class="mr-4">
                <x-npl::infos.info-list  id='mySearch'  class="text-center" >
                    <x-npl::infos.info-item title="Nbr Tronc" value="0 " icon="assignment_turned_in" couleur="success" id_value="total_tronc_info" />
                    <x-npl::infos.info-item title="Nbr Kl" value="0 Kg" icon="assignment_turned_in" couleur="success" id_value="total_poids_info" />
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar>

@endsection

@section('ly-main-content')
    <x-achat.util.add-tronc :model="$achat"  />
@endsection








@push('script')
<script>

</script>
@endpush
