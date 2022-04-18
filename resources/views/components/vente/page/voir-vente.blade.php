@extends('npl::layouts.ly')
@section('ly-toolbar')
<x-npl::tool-bar.bar >
    <x-npl::tool-bar.prev-button id="prev_tb"  url="/vente/"  />
    <x-npl::tool-bar.link id="nouveau_vente_tb" text="Nouveau" icon="add" url="/vente/create" evidence="btn-primary" :canAccess="['vente_bois',['c']]" />
    <x-npl::tool-bar.link id="modifier_vente_tb" text="Modifier" icon="edit" :url="url('vente/'.$vente->id.'/edit')" :canAccess="['vente_bois',['u']]" />
    <x-npl::tool-bar.button id="supprimer_vente_tb" text="Supprimer" icon="delete"  disabled="disabled" :canAccess="['vente_bois',['d']]" />
    <x-npl::tool-bar.divider/>
    <x-npl::tool-bar.button id="imprimer_prod_tb" text="Imprimer" icon="print"  />
    {{-- @if(Auth::user()->role->nom=='Caissier' || Auth::user()->role->nom=='Administration') --}}
        <x-npl::tool-bar.link  :url="url('vente/print_facture/'.$vente->id)" id="imprimer_facture_prod_tb" text="ImprimerFacture" icon="print"  />
    {{-- @endif --}}
    <x-npl::tool-bar.divider/>
    {{-- @if ($is_commande)
        <x-npl::tool-bar.ajax :url="url('vente/preter/'.$vente->id)" method='get'
                :redirect="'vente/'.$vente->id" idAlert="addVenteAlert" id="pret_vente_tb" text="Preter" icon="payment" evidence="btn-warning" :canAccess="['encaissement',['c']]"  />
    @else --}}
        <x-npl::tool-bar.button-modal id="add_py_vente_tb" text="Ajouter Paiement" icon="add_shopping_cart" target="modal_new_ligne_paiement"  evidence="btn-success" :canAccess="['encaissement',['c']]" />

    {{-- @endif --}}


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
                <a href="{{ url('vente/') }}">Ventes</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{$vente->numero()}}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>


        <x-slot name="right">
            <div class="mr-4 m-sm-0 mx-sm-0 ">
                <x-npl::infos.info-list >


                    <x-npl::infos.info-item title="Somme à payer" value="{{number_format($vente->sumRestant(),0,'',' ')}} FCFA" icon="payments" typeIcon="material-icons-outlined" id_value="montant_restant_info" />
                        <x-npl::infos.info-item title="Montant Total" value="{{number_format($vente->sumVente(),0,'',' ')}} FCFA" icon="equalizer" />
                        @if($vente->etat=="complete")
                             <x-npl::infos.info-item title="Etat Vente" value="COMPLETE" icon="assignment_turned_in" couleur="success" id_value="etat_vente_info" />
                        @elseif($vente->etat=="accompte"){{--  ou livraison incomplete --}}
                             <x-npl::infos.info-item title="Etat Vente" value="ACCOMPTE" icon="assignment_turned_in" couleur="danger" id_value="etat_vente_info"/>
                        @elseif($vente->etat== \App\ModelHaut\VenteHaut::PAYE_NON_LIVRE)
                             <x-npl::infos.info-item title="Etat Vente" value="PAYE_NON_LIVRE" icon="assignment_turned_in"  id_value="etat_vente_info" />
                        @else
                             <x-npl::infos.info-item title="Etat Vente" value="COMMANDE" icon="assignment_turned_in" couleur="warning" id_value="etat_vente_info" />
                        @endif
                        <x-npl::infos.info-item title="Date Vente" value="{{date('d-m-Y H:i', strtotime($vente->created_at))}} " icon="save" />

                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar >
</div>
@endsection

@section('ly-alert')
<div class="" id="addVenteAlert" style="position: sticky;top:43px;border-radius:0px;"></div>
@endsection




@section('ly-main-content')
    <x-vente.util.voir-vente :vente=$vente/>
@endsection

@section('ly-main-bot')
       <div class="col-md-6">
            <span class="mr-2">
               <span>Total Paiement: </span>
               <span>{{number_format($vente->sumPayement(),0,',',' ')}}</span>
               <span class="badge badge-primary ">FCFA</span>
            </span>

            <span class="mr-2">
                 Poids Total:
                 <span>{{number_format($vente->sumKg(),0,',',' ')}}</span>
                 <span class="badge badge-success"> kg</span>
            </span>
            <span class="mr-2">
                Nombre de Tronc: {{$vente->countTronc()}} ;
            </span>



       </div>
@endsection


@push('modal')
    <x-vente.modal.paiement :model="$vente" dataTableId="myDataTable2" />
@endpush

@push("script")
    <script>
        $(function(){
            $("#imprimer_prod_tb").on('click',function(){
                $.ajax({
                    url: "{{ url('vente/print/'.$vente->id) }}",
                    type: "get",
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if(response.status){
                          win=window.open();
                          win.document.write(response.html);
                          if(navigator.userAgent.toLowerCase().indexOf('chrome') > -1){   // Chrome Browser Detected?
                                win.PPClose = false;                                     // Clear Close Flag
                                win.onbeforeunload = function(){                         // Before win Close Event
                                    if(win.PPClose === false){                           // Close not OK?
                                        return 'Leaving this page will block the parent win!\nPlease select "Stay on this Page option" and use the\nCancel button instead to close the Print Preview win.\n';
                                    }
                                }


                                win.print();                                             // Print preview
                                win.PPClose = true;
                                                               // Set Close Flag to OK.
                            }
                        }

                    },
                    error: async function (err){
                        $.fn.nplAlertBarShow('#addVenteAlert',response.message,"alert alert-danger","alert alert-success",1);

                    }
                });
            });
        });
    </script>
@endpush




