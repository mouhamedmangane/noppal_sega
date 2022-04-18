@if(isset($achat->id))
   @props([
        'url_form'=>url("achat/".$achat->id),
        'method_form'=>'post'
   ])
@else
    @props([
        'url_form'=>url("achat"),
        'method_form'=>'post'
    ])
@endif

<form action="{{ $url_form}}" enctype="" id="addAchat" class=" mt-2" method="post">
    @if(isset($achat->id))
        @method('PUT')
    @endif
    @csrf
    <div class="px-4 " >
        <div class="row">
            <div class=" col-lg-6 col-md-8 col-sm-12">
                    <x-npl::forms.form-table >
                        <x-npl::forms.form-table-select name="fournisseur"  placeholder="Nom du client" required="true"
                                              id="fournisseur" class="" labelText="Fournisseur"
                                              :dt="$getFournisseur" :value="$achat->fournisseur_id"  />

                        <x-npl::forms.form-table-select name="chauffeur"  placeholder="Nom du client" required="true"
                                            id="chauffeur" class="" labelText="Chauffeur"
                                            :dt="$getChauffeur" :value="$achat->chauffeur_id"  />

                        <x-npl::forms.form-table-text name="poids" :value="$achat->poids" labelText="Poids Fournisseur" type="number"
                                            placeholder="Poids donné par le fournisseur" id="poids" />

                        <x-npl::forms.form-table-line>
                            <x-slot name="label">
                                Montant
                            </x-slot>
                            <x-npl::input.radios name="type_montant" :dt="['detail'=>'Detail','global'=>'Global']"
                                defaultSelected="{{($achat->somme_detail)?'detail':'global' }}"  classRadio="type_montant" />
                            <div class="d-flex">
                                    <x-npl::input.text name="somme_detail" :value="($achat->somme_detail)?$achat->somme_detail:90" id="somme_detail" />
                                    <div class="mx-1"></div>
                                    <x-npl::input.text name="somme"  id="somme" :value="$achat->somme" />
                            </div>
                        </x-npl::forms.form-table-line>

                        <x-npl::forms.form-table-textarea name="note" labelText="Note" rows="3"
                                            placeholder="note ..." id="note" />


                    </x-npl::forms.form-table >
            </div>
        </div>

    </div>

    {{-- <button name="" id="" class="btn btn-success " type="submit">Envoyer</button> --}}


</form>

@push('script')
    <script>
        $(function(){
            $('#addAchat').ajaxPush("{{url('achat/ajaxPush')}}");


            function update_somme_global(){
                let type= $("input[name='type_montant']:checked").val();
                if(type=='detail'){
                    $('#somme_detail').show();

                    $('#somme').val($('#somme_detail').val() * $("#poids").val());
                    $('#somme').prop('readonly',true);
                }
                else{
                    $('#somme_detail').hide();
                    $('#somme').prop('readonly',false);

                }
            }
            update_somme_global();

            $(".type_montant").on('change',function(){
                update_somme_global();
            });
            $('#somme_detail,#poids').on('keyup',function(){
                update_somme_global();
            })
        });
    </script>
@endpush


