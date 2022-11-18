


@section("ly-main-top")
<x-npl::navs-tabs.nav id="myTab" class="px-2  ">
    <x-npl::navs-tabs.item text="Information General" idPane="general"  id="general-tab"  active="true" classLink="ml-3" />
    <x-npl::navs-tabs.item text="Troncs" idPane="troncs" id="achat-tab" :badge="$achat->nbrTronc()" badgeType="badge-primary" />
    <x-npl::navs-tabs.item text="Paiement" idPane="paiement" id="paiement-tab" :badge="($achat->nbrPaiement())? $achat->nbrPaiement():'0 '" badgeType="badge-success"/>
    {{-- <x-npl::navs-tabs.item text="Frais" idPane="frais" id="frais-tab" :badge="($achat->nbrFrais())?$achat->nbrFrais():'0 '" badgeType="badge-warning"/> --}}
    <x-npl::navs-tabs.item text="Details" idPane="details" id="detail-tab"  />
</x-npl::navs-tabs.nav>
@endsection
    <x-npl::navs-tabs.content id="myTabContent" class="px-4 py-3" >
      <x-npl::navs-tabs.pane id="general" active="true" >
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="border shadow">
                    <div >
                        <h5 class="pt-3 pb-2 px-3 ">Info General</h5>
                    </div>
                    <div class="">
                        <x-npl::table.key-value-list class="w-100 liste-simple ">
                            <x-npl::table.key-value-list-item key="Numero : " :value="'AS-'.$achat->id" />
                            <x-npl::table.key-value-list-item key="Fournisseur :" :value="$achat->fournisseur->nameAndPhone()" />
                            <x-npl::table.key-value-list-item key="somme :" :value="number_format($achat->somme,0,'.',' ').' FCFA'" />
                            <x-npl::table.key-value-list-item key="Poids Founisseur :" :value="number_format($achat->poids,0,'.',' ').' Kg'" />
                            <x-npl::table.key-value-list-item key="Chauffeur :" value="" >
                                <x-slot name="valuee">
                                    <span class="font-weight-bold" style="font-size:15px ">
                                        @if ($achat->chauffeur_id)
                                            {{$achat->chauffeur->nameAndPhone()}}
                                        @else
                                            ---------------
                                        @endif
                                    </span>


                                </x-slot>

                            </x-npl::table.key-value-list-item>
                            <x-npl::table.key-value-list-item key="Modifer le :" :value="$achat->updated_at->format('d/m/Y \à H\h i \m\n')" />
                            <x-npl::table.key-value-list-item key="Crée le :" :value="$achat->created_at->format('d/m/Y \à H\h i \m\n')" />
                        </x-npl::table.key-value-list>
                    </div>

                </div>

            </div>

            <div class="col-md-6 col-sm-12 my-sm-1">
                <div class="border shadow">
                    <div >
                        <h5 class="pt-3 pb-2 px-3 ">Bilan</h5>
                    </div>
                    <div class="">
                        <x-npl::table.key-value-list class="w-100 liste-simple ">
                            <x-npl::table.key-value-list-item key="Poids Pesé: " :value="number_format($achat->poidsReel(),0,'.',' ').' Kg'" />
                            <x-npl::table.key-value-list-item key="Nombre de Tronc" :value="$achat->nbrTronc().' unité(s)'" />
                            <x-npl::table.key-value-list-item key="Total Paiement :" :value="number_format($achat->totalPaiement(),0,'.',' ').' FCFA'" id_value="total_paiement_info-ls" />
                            <x-npl::table.key-value-list-item key="Total Frais :" :value="number_format($achat->totalFrais(),0,'.',' ').' FCFA'" id_value="total_frais_info-ls" />
                            <x-npl::table.key-value-list-item key="Restant :" :value="number_format($achat->restant(),0,'.',' ').' FCFA'" id_value="restant_info-ls"  />
                        </x-npl::table.key-value-list>
                    </div>

                </div>

            </div>

        </div>
      </x-npl::navs-tabs.pane>


      <x-npl::navs-tabs.pane id="troncs" >
            <x-npl::data-table.simple
                class=" "
                dom='rftp'
                scrollY="100%"
                idDivPaginate="tronc-left-pag"
                name="myDataTable" url="{{ url('/achat/tronc_data/'.$achat->id) }}" :columns="$getTitle()"
                pagingType="full"

            />
            <div class="d-flex justify-content-end">
                <div id="tronc-left-pag">

                </div>

            </div>
      </x-npl::navs-tabs.pane>

      <x-npl::navs-tabs.pane id="paiement" >
        <div class="row d-flex ">
            <div class="col-md-8 col-sm-12 " >
                     <x-npl::data-table.simple class="" name="myDataTable2"
                         :url="url('achat/depense/data/paie/'.$achat->id)"
                         :columns="$titlePayement()" dom="t"
                         scrollY='100%'/>
            </div>
        </div>

      </x-npl::navs-tabs.pane>

      {{-- <x-npl::navs-tabs.pane id="frais" >
        <div class="row d-flex ">
            <div class="col-md-8 col-sm-12 " >
                     <x-npl::data-table.simple class="" name="myDataTable3"
                         :url="url('achat/depense/data/frais/'.$achat->id)"
                         :columns="$titlePayement()" dom="t"
                         scrollY='100%'/>
            </div>
        </div>
      </x-npl::navs-tabs.pane> --}}

      <x-npl::navs-tabs.pane id="details"  >
          <div class="row">

                <div class="col-md-4 col-sm-12">
                    <x-util.detail :model="$achat" />
                </div>
                <div class="col-md-7 ml-1 col-sm-12">
                    <h6>Note</h6>
                    <p>{{$achat->note}}</p>
                </div>

          </div>

        </x-npl::navs-tabs.pane>

    </x-npl::navs-tabs.content>



    @push('script2')
    <script>
        $(function(){

            function updateInfo(reponse){
                $('#restant_info').html(new Intl.NumberFormat().format(reponse.restant)+' FCFA');
                $('#restant_info-ls').html(new Intl.NumberFormat().format(reponse.restant)+' FCFA');
                $('#total_paiement_info').html(new Intl.NumberFormat().format(reponse.prix_revient)+' FCFA');
                $('#total_paiement_info-ls').html(new Intl.NumberFormat().format(reponse.total_paiement)+' FCFA');
                $('#paiement-tab .badge').html(new Intl.NumberFormat().format(reponse.nbr_paie));
                $('#frais-tab .badge').html(new Intl.NumberFormat().format(reponse.nbr_frais));
            }

            function process(numberTable){
                let idDataTable='#myDataTable'+numberTable;
                var table = $(idDataTable).DataTable();
                table.on('draw.dt',function(){
                    $(idDataTable+' .btn-edit-paiement').on('click',function(){
                        $('#paiement_id_md').val($(this).data('id'));
                        $('#somme_md').val($(this).data('somme'));
                        $("#type_depense_modal").val($(this).data('typedepense'));

                        $('#modal_new_ligne_paiement').modal('show');

                    });
                    $(idDataTable+' .btn-delete-paiement').on('click',function(){
                        let id=$(this).data('id');
                        $.ajaxSetup({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{ url('achat/paiement/delete') }}",
                            type: "delete",
                            data:{
                                'id':id
                            },
                            dataType: "json",
                            success: function (response) {
                                if(response.status){
                                    // $.fn.nplAlertBarShow('#addVenteAlert',response.message,"alert alert-success","alert alert-danger",1);
                                    // let dataTableNumber=(response.type_depense=="paie")?'2':'3';
                                    // let dataTable=$("#myDataTable"+dataTableNumber).DataTable();
                                    // dataTable.ajax.reload();
                                     table.ajax.reload();
                                    updateInfo(response);
                                }
                                else{
                                    $.fn.nplAlertBarShow('#addVenteAlert',response.message,"alert alert-danger","alert alert-success",0);
                                }
                            },
                            error: async function (err){
                                $.fn.nplAlertBarShow('#addVenteAlert',response.message,"alert alert-danger","alert alert-success",1);

                            }
                        });

                    });
                })
            }

            process(2);
            process(3);



        })

    </script>
    @endpush


