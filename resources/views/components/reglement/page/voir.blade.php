@extends('npl::layouts.ly')
@section('ly-toolbar')
<x-npl::tool-bar.bar >
    @if(!$reglement->etat)
    <x-npl::tool-bar.prev-button id="prev_tb"  url="/reglement"  />
    <x-npl::tool-bar.button id="regler_reglement_tb" text="Régler" icon="check" evidence="btn-primary"/>
    <x-npl::tool-bar.divider/>
    <x-npl::tool-bar.button-modal id="add_py_reglement_tb" text="Paiement" icon="add" target="modal_new_ligne_paiement"  evidence="btn-success" :canAccess="['reglement_paiement',['c']]" />
    <x-npl::tool-bar.link id="add_achat_reglement_tb" :url="url('achat/create/reglement/'.$reglement->id.'')"  text="Chargement" icon="add" target="modal_new_ligne_paiement"  evidence="btn-warning" :canAccess="['reglement_achat',['c']]" />
    @endif

    <x-npl::tool-bar.link  :url="url('reglement/fournisseur/'.$reglement->fournisseur_id.'/list')" id="prod_tb" text="Historique" icon="receipt_long"  />

    <x-npl::tool-bar.button id="last_chargement_tb" text="Dernier Chargement" icon="hourglass_bottom"  : />
    {{-- @if(Auth::user()->role->nom=='Caissier' || Auth::user()->role->nom=='Administration') --}}
    {{-- @endif --}}
    <x-npl::tool-bar.divider/>
    @if(!$reglement->etat)
    <x-npl::tool-bar.button-modal id="modifier_initial_tb" text="Initial" icon="edit" target="modal_edit_initial" />
    @endif




</x-npl::tool-bar.bar >
@endsection
@section('ly-title')
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="point_of_sale" taille="40" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('reglement/') }}">Fournisseurs</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
               {{ucfirst($reglement->fournisseur->id)}} RS-{{$reglement->id}}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>


        <x-slot name="right">
            <div class="mr-4 m-sm-0 mx-sm-0 ">
                <x-npl::infos.info-list >
                    <x-npl::infos.info-item title="Etat Fournisseur" value="{{number_format($total,0,'',' ')}} FCFA" icon="equalizer" couleur="{{$totalColor}}" id_value="last_info" />
                    <x-npl::infos.info-item title="Initial" value="{{number_format($reglement->initial,0,'',' ')}} FCFA" icon="payments" typeIcon="material-icons-outlined" id_value="initial_info" />
                    <x-npl::infos.info-item title="Etat" value="{{($reglement->etat)?'Ouvert':'Fermé'}}" icon="close" couleur="{{($reglement->etat)?'success':'warning'}}" id_value="etat_info"/>
                    <x-npl::infos.info-item title="Date reglement" value="{{date('d-m-Y H:i', strtotime($reglement->created_at))}} " icon="save" />

                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar >
@endsection

@section('ly-alert')
    <div class="" id="addreglementAlert" style="position: sticky;top:43px;border-radius:0px;"></div>
@endsection




@section('ly-main-content')
    <x-reglement.util.voir :reglement="$reglement" />
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


@push('modal')
    <x-reglement.modal.paiement :model="$reglement" dataTableId="myDataTable2" />
    <x-reglement.modal.edit-initial :model="$reglement"  />
@endpush

@push("script")
<script>
    $(function(){
        $('#last_chargement_tb').on('click',function(){
            let id="{{$reglement->id}}";
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('reglement/'.$reglement->id).'/last_chargement' }}",
                    type: "get",
                    data:{
                        'id':id
                    },
                    dataType: "json",
                    success: function (response) {
                        if(response.status){
                            $.fn.nplAlertBarShow('#addreglementAlert',response.message,"alert alert-success","alert alert-danger",1);
                            window.location.href="{{ url('achat/tronc')}}/"+response.id;
                        }
                        else{
                            $.fn.nplAlertBarShow('#addreglementAlert',response.message,"alert alert-danger","alert alert-success",1);
                        }
                    },
                    error: async function (err){
                        $.fn.nplAlertBarShow('#addreglementAlert',response.message,"alert alert-danger","alert alert-success",1);

                    }
                });
        });



        $('#regler_reglement_tb').on('click',function(){
            let id="{{$reglement->id}}";
            if(confirm("Êtes vous sure de régler")){
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('reglement/valider/'.$reglement->id) }}",
                    type: "get",
                    data:{
                        'id':id
                    },
                    dataType: "json",
                    success: function (response) {
                        if(response.status){
                            $.fn.nplAlertBarShow('#addreglementAlert',response.message,"alert alert-success","alert alert-danger",1);
                            window.location.href="{{ url('reglement')}}/"+response.id;
                        }
                        else{
                            $.fn.nplAlertBarShow('#addreglementAlert',response.message,"alert alert-danger","alert alert-success",0);
                        }
                    },
                    error: async function (err){
                        $.fn.nplAlertBarShow('#addreglementAlert',response.message,"alert alert-danger","alert alert-success",1);

                    }
                });




            }
        });
    });
</script>
@endpush




