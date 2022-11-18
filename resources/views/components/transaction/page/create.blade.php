@extends('npl::layouts.ly')
@section('ly-toolbar')
    <x-npl::tool-bar.bar>
        <x-npl::tool-bar.prev-button id="prev_tb" :url="url('transaction')"/>
        <x-npl::input.button-submit id="submit_produit_tb"
                                    idForm="create_transaction_form"
                                    idContentAlert="listtransactionAlert"
                                    class="tb-btn btn btn-primary btn-sm d-flex align-items-center mr-3"
                                    text="Enregistrer"
                                    hrefId="transaction"
                                    parentMessageClass=""
                                    elementMessageClass=""
                                    :isReset="false"
                                    icon="save"/>


        <x-npl::tool-bar.divider/>

        <x-npl::tool-bar.link id="person_add" icon="person_add" url="/transaction/create" text="Nouveau transaction"  />

    </x-npl::tool.bar.bar>
@endsection

@section('ly-alert')
    <x-npl::alert.bar id='listtransactionAlert' />
@endsection

@section('ly-title')
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="person" taille="16" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('transaction') }}">Transactions</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{ (isset($transaction->id)    )?$transaction->numero():'Nouveau transaction' }}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>

        <x-slot name="right">
            <div class="mr-4">
                <x-npl::infos.info-list >

                    @if(isset($transaction->id))
                        <x-npl::infos.info-item title="Total transaction" :value="12" icon="assignment_turned_in" couleur="success" />
                        <x-npl::infos.info-item title="Total Groupe" :value="12" icon="assignment_turned_in" couleur="warning" />

                    @endif
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar>
@endsection

@section('ly-main-content')
        <x-transaction.util.create  :model="$transaction" />

@endsection
