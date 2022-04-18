@extends('npl::layouts.ly-sans')
@section('ly-toolbar')
    <x-npl::tool-bar.bar >
        @if($achat->id)
            <x-npl::tool-bar.prev-button id="prev_tb"  :url="url('achat/'.$achat->id)"  />
        @else
            <x-npl::tool-bar.prev-button id="prev_tb"  url="/achat/"  />
        @endif
        <x-npl::input.button-submit  id="test-button-submit"
                                        idForm="addAchat"
                                        idContentAlert="addAchatAlert"
                                        class="btn btn-primary btn-sm d-flex align-items-center mr-3 "
                                        text="Enregistrer"
                                        hrefId="achat"
                                        parentMessageClass="n-form-table-col-input"
                                        elementMessageClass="form-table-feedback"
                                        icon="save"/>
        <x-npl::tool-bar.button id="" text="Annuler" icon="clear" evidence=""  />

    </x-npl::tool-bar.bar >
@endsection


@section('ly-alert')
    <div class="" id="addAchatAlert" style="position: sticky;top:43px;border-radius:0px;"></div>
    <div class="" id="infoAchatAlert" style="position: sticky;top:43px;border-radius:0px;"></div>

@endsection

@section('ly-title')
<x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="add_shopping_cart" taille="16" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('achat') }}">Achat</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{ (isset($achat->id)    )?'VS-'.$achat->id:'Nouvelle Achat' }}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>

        <x-slot name="right">
            <div class="mr-4">
                <x-npl::infos.info-list>
                    <x-npl::infos.info-item title="Total Paiement" :value="$total_paiement_info.' FCFA'" icon="assignment_turned_in"  id_value="m_total_kg"/>
                    <x-npl::infos.info-item title="Total Frais" :value="$total_frais_info.' FCFA'" icon="assignment_turned_in"  id_value="m_total_kg"/>
                    <x-npl::infos.info-item title="Total kg" :value="$total_kl_info.' KG'" icon="assignment_turned_in" couleur="success" id_value="m_total_kg"/>
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar>
@endsection



@section('ly-main-content')
    <x-achat.util.create :model="$achat" />
@endsection

@section('ly-main-bot')



@endsection

@push('script')
<script>
    $(function(){
        @if (!$achat->somme >0 && $achat->restant()<0)
            $('#addAchatAlert').html("Veillez completer l'achat <a href='{{url('achat/'.$achat->id.'/edit')}}' class='lien-sp'> cliquer ici </a>pour modifier");
            $('#addAchatAlert').addClass("alert alert-danger alert-dismissible fade show");
            $('#addAchatAlert').append('<button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <span aria-hidden="true">&times;</span> \
                                        </button>/');


        @elseif (!$achat->isSemiComplete())
            $('#addAchatAlert').html("Veillez rensegner le montant et le poids  de l'achat <a href='{{url('achat/'.$achat->id.'/edit')}}' class='lien-sp'> cliquer ici </a>pour modifier");
            $('#addAchatAlert').addClass("alert alert-warning alert-dismissible fade show");
            $('#addAchatAlert').append('<button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <span aria-hidden="true">&times;</span> \
                                        </button>/');

        @endif

    });
</script>

@endpush


