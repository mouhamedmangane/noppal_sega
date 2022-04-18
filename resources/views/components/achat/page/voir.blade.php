@extends('npl::layouts.ly')
@section('ly-toolbar')
<x-npl::tool-bar.bar >

   <x-npl::tool-bar.prev-button id="prev_tb"  url="/achat/"  />

    <x-npl::tool-bar.link id="nouveau_achat_tb" text="Nouveau" icon="add" url="/achat/create" evidence="btn-primary" :canAccess="['achat_bois',['c']]" />
    <x-npl::tool-bar.link id="modifier_achat_tb" text="Modifier" icon="edit" :url="url('achat/'.$achat->id.'/edit')" :canAccess="['achat_bois',['u']]" />
    <x-npl::tool-bar.button id="supprimer_achat_tb" text="Supprimer" icon="delete"  disabled="disabled" :canAccess="['achat_bois',['d']]" />
    <x-npl::tool-bar.divider/>
    <x-npl::tool-bar.link id="tronc_achat_tb" text="Tronc" icon="post_add" :url="url('achat/tronc/'.$achat->id)" evidence="btn-primary" :canAccess="['achat_bois',['c']]" />
    <x-npl::tool-bar.button-modal id="add_py_achat_tb" text="Ajouter Paiement" icon="add_shopping_cart" target="modal_new_ligne_paiement"  evidence="btn-success" :canAccess="['encaissement',['c']]"  :disabled="$achat->isComplete()"/>
    <x-npl::tool-bar.button-modal id="add_fre_achat_tb" text="Ajouter Frais" icon="add_shopping_cart" target="modal_new_ligne_paiement"  evidence="btn-warning" :canAccess="['encaissement',['c']]"  :disabled="$achat->isComplete()" />

    <x-npl::tool-bar.divider/>
    <x-npl::tool-bar.button id="imprimer_achat_tb" text="Imprimer" icon="print"  />

        {{-- <x-npl::tool-bar.ajax :url="url('achat/preter/'.$achat->id)" method='get'
                :redirect="'achat/'.$achat->id" idAlert="addAchatAlert" id="pret_achat_tb" text="Preter" icon="payment" evidence="btn-warning" :canAccess="['encaissement',['c']]"  /> --}}




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
                <a href="{{ url('achat/') }}">Achats</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                {{$achat->numero()}}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>


        <x-slot name="right">
            <div class="mr-4 m-sm-0 mx-sm-0 overflow-x-sm-auto">
                <x-npl::infos.info-list>
                    <x-npl::infos.info-item title="Restant Paiement" :value="$restant_info.' FCFA'" icon="assignment_turned_in"  :couleur="$couleur_restant_info" id_value="restant_info"/>
                    <x-npl::infos.info-item title="Prix Revient" :value="$total_prix_revient_info.' FCFA'" icon="assignment_turned_in" couleur="danger" id_value="total_paiement_info"/>
                    <x-npl::infos.info-item title="Total Vente " :value="$total_vente_info.' FCFA'" icon="assignment_turned_in" couleur="success" id_value="total_vente_info"/>
                    <x-npl::infos.info-item title="Vendu / Total kg" :value="$total_kl_info.' KG'" icon="assignment_turned_in"  id_value="m_total_kg"/>
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar >
</div>
@endsection

@section('ly-alert')
<div class="" id="addAchatAlert" style="position: sticky;top:43px;border-radius:0px;"></div>
@endsection




@section('ly-main-content')
    <x-achat.util.voir :model="$achat" />
@endsection

@section('ly-main-bot')
       <div class="col-md-6">




       </div>
@endsection


@push('modal')
    <x-achat.modal.add-paiement :model="$achat" dataTableId="myDataTable2" />
@endpush

@push('script')
<script>
    $(function(){
        function onclickBtnDepense(type_depense,numeroDt){
            $("#type_depense_modal").val(type_depense);
            $("#data_table_id_md").val('myDataTable'+numeroDt);
            $('#paiement_id_md').val(0);
            $('#somme_md').val(0);
        }
        $('#add_py_achat_tb').on('click',function(){
            onclickBtnDepense('paie',2);
        });

        $('#add_fre_achat_tb').on('click',function(){
            onclickBtnDepense('frais',3);
        });
    });
</script>

@endpush

{{-- alert montant ou poids null --}}
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

@push("script")
    <script>
        $(function(){
            $("#imprimer_achat__tb").on('click',function(){
                $.ajax({
                    url: "{{ url('achat/print/'.$achat->id) }}",
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
                        $.fn.nplAlertBarShow('#addAchatAlert',response.message,"alert alert-danger","alert alert-success",1);

                    }
                });
            });
        });


    </script>
@endpush




