@extends('npl::layouts.ly')
@section('ly-toolbar')
<x-npl::tool-bar.bar >

   <x-npl::tool-bar.prev-button id="prev_tb"  url="/transaction/"  />

    <x-npl::tool-bar.link id="nouveau_transaction_tb" text="Nouveau" icon="add" url="/transaction/create" evidence="btn-primary" />
    @if($transaction->updatable)
        <x-npl::tool-bar.link id="modifier_transaction_tb" text="Modifier" icon="edit" :url="url('transaction/'.$transaction->id.'/edit')"  />
        <x-npl::tool-bar.button id="supprimer_transaction_tb" text="Supprimer" icon="delete"  />
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
                <a href="{{ url('transaction/') }}">Transactions</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{$transaction->numero()}}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>


        <x-slot name="right">
            <div class="mr-4 m-sm-0 mx-sm-0 overflow-x-sm-auto">
                <x-npl::infos.info-list>
                    <x-npl::infos.info-item title="crée le" :value="$transaction->created_at->format('d-m-Y')" icon="assignment_turned_in"  id_value="creer_le_info"/>
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar >
</div>
@endsection

@section('ly-alert')
<div class="" id="addtransactionAlert" style="position: sticky;top:43px;border-radius:0px;"></div>
@endsection




@section('ly-main-content')
    <x-transaction.util.voir :model="$transaction" />
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




