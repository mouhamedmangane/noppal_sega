
@extends('npl::layouts.ly-list')
@section('ly-toolbar')
    <x-npl::tool-bar.bar >
        <x-npl::input.button-submit  id="test-button-submit"
                                        idForm="update_entreprise_form"
                                        idContentAlert="entrepriseAlert"
                                        class="btn btn-primary btn-sm d-flex align-items-center mr-3 "
                                        text="Enregistrer"
                                        href="/param-compte/entreprise"
                                        parentMessageClass="n-form-table-col-input"
                                        elementMessageClass="form-table-feedback"
                                        icon="save"/>

    </x-npl::tool-bar.bar >
@endsection

@section('ly-alert')
    <div class="" id="entrepriseAlert" style="position: sticky;top:43px;border-radius:0px;"></div>
@endsection
@section('ly-title')
<x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="gavel" taille="16" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item active="true">
                L'Entreprise
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>
        <x-slot name="right">
        </x-slot>


    </x-npl::title-bar.bar >
@endsection



@section('ly-main-content')
    <x-entreprise.util.update :model="$entreprise"  />
@endsection



@once
    @push('script')
        <script type="text/javascript">
        </script>
    @endpush
@endonce
