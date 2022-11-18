@section("ly-main-top")
<x-npl::navs-tabs.nav id="myTab" class="px-2  ">
    <x-npl::navs-tabs.item text="Information Vente" idPane="general"  id="general-tab"  active="true" classLink="ml-3" />
    <x-npl::navs-tabs.item text="Paiement" idPane="paiement" id="paiement-tab" />

    <x-npl::navs-tabs.item text="Details" idPane="details" id="detail-tab"  />
</x-npl::navs-tabs.nav>
@endsection
    <x-npl::navs-tabs.content id="myTabContent" class="px-4 py-3 px-sm-1" >
      <x-npl::navs-tabs.pane id="general" active="true" >
         <div class=" d-flex  flex-wrap-sm ">
               <div class="d-flex  px-2 align-item-center justify-content-center flex-wrap wr-150 w-sm-100" style="">
                        <div class="col-md-12 col-sm-6 ">
                            <div class="d-flex justify-content-center ">
                                <x-npl::input.photo id="photo" name="photo" activeText="false" circle="true"
                             :url="(isset($vente->client->photo) && !empty($vente->client->photo))?asset('images/contacts/'.$vente->client->photo):''"
                             x="100" y="100" />
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-6 text-align-center d-flex align-items-center ">
                                @if($vente->client)
                                    <x-npl::links.simple :url='url("contact/".$vente->contact_id)' :text="$vente->client->nameAndphone()" class="lien-sp" />
                                @else
                                    <span>
                                        {{ ucfirst( $vente->nom)." / ".$vente->telephone }}
                                    </span>
                                    <a href="{{url('contact/createtovente/'.$vente->id.'/'.$vente->nom.'/'.$vente->telephone)}}" class="btn btn-sm btn btn-outline-primary rounded-circle">
                                        <i class="material-icons md-14" >add</i>
                                    </a>
                                @endif
                                <br>
                        </div>



               </div>

            <div class=" flex-grow-1">
                <div class="d-flex justify-content-center w-100 border shadow  overflow-x-auto">

                            <x-npl::data-table.simple
                                    class="" name="myDataTable" :data="$ventes()"
                                    scrollY="100%"
                                    :columns="$titre()"
                                    dom="t"/>




                </div>
            </div>
         </div>
      </x-npl::navs-tabs.pane>

      <x-npl::navs-tabs.pane id="paiement" >
         <div class="row d-flex justify-content-center ">
               <div class="col-md-6 col-sm-12  " >
                        <div class="shadow border px-2">
                                <x-npl::data-table.simple class="" name="myDataTable2"
                                    :url="url('vente/paiement/data/'.$vente->id)"
                                    :columns="$titlePayement()" dom="t"
                                    scrollY='100%'/>
                        </div>


               </div>
               <div class="col-md-6 col-sm-12">
                  {{-- <x-npl::forms.form-table >
                     <x-npl::forms.form-table-item>
                        <x-npl::data-table.simple class="" name="myDataTableL" :data="$livraisons()" :columns="$titleLivraison()" dom="t"
                           idDivPaginate="bass-right" idDivInfo="bas-left" searchId='mySearch'/>
                     </x-npl::forms.form-table-item>
                  </x-npl::forms.form-table> --}}
               </div>
         </div>


      </x-npl::navs-tabs.pane>

      <x-npl::navs-tabs.pane id="details"  >
          <div class="row">

                <div class="col-md-4 col-sm-12 ">
                    <x-util.detail :model="$vente" />
                </div>
                <div class="col-md-7 ml-1 col-sm-12 px-0">
                    <div class=" rounded p-2 bg-warning border-warning mx-2">
                        <h6>Note :</h6>
                        <p>{{$vente->note}}</p>
                    </div>

                </div>

          </div>
        @if($vente->id)
        @endif
    </x-npl::navs-tabs.pane>

    </x-npl::navs-tabs.content>


@push('script2')
<script>
    $(function(){

        function updateInfo(montant,etat){
            $("#montant_restant_info").html(montant);
            $("#etat_vente_info").html(etat);
            if(etat=="commande"){
                $("#etat_vente_info").css('color','var(--danger)')
            }else if(etat=="accompte"){
                $("#etat_vente_info").css('color','var(--warning)')
            }
            else if(etat=="complete"){
                $("#etat_vente_info").css('color','var(--success)')
            }

        }

        var table = $('#myDataTable2').DataTable();
        table.on('draw.dt',function(){
            $('.btn-edit-paiement').on('click',function(){
                $('#paiement_id_md').val($(this).data('id'));
                $('#somme_md').val($(this).data('somme'));
                $('#modal_new_ligne_paiement').modal('show');

            });
            $('.btn-delete-paiement').off();
            $('.btn-delete-paiement').on('click',function(){
                if(confirm("Êtes vous sûre de supprimer le paiement")){
                    let id=$(this).data('id');
                    $.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ url('vente/paiement/delete') }}",
                        type: "delete",
                        data:{
                            'id':id
                        },
                        dataType: "json",
                        success: function (response) {
                            if(response.status){
                                $.fn.nplAlertBarShow('#addVenteAlert',response.message,"alert alert-success","alert alert-danger",1);
                                let dataTable=$("#myDataTable2").DataTable();
                                dataTable.ajax.reload();
                                updateInfo(response.montant_restant,response.etat);
                            }
                            else{
                                $.fn.nplAlertBarShow('#addVenteAlert',response.message,"alert alert-danger","alert alert-success",0);
                            }
                        },
                        error: async function (err){
                            $.fn.nplAlertBarShow('#addVenteAlert',response.message,"alert alert-danger","alert alert-success",1);

                        }
                    });
                }

            });

        })
    })

</script>
@endpush

