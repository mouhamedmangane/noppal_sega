
@if(isset($vente->id))
   @props([
        'url_form'=>url("vente/".$vente->id),
        'method_form'=>'post',
        'clientidd'=>$vente->contact_id
   ])
@else
    @props([
        'url_form'=>url("vente"),
        'method_form'=>'post',
        'clientidd'=> $attributes['clientid']
    ])
@endif

<form action="{{ $url_form}}" enctype="" id="addVente" class=" mt-2" method="post">
    @if(isset($vente->id))
        @method('PUT')
    @endif
    @csrf
    <div class="px-4 nmx-sm-0" >
                    <x-npl::forms.form-table >
                        <x-npl::forms.form-table-item  >
                            <div class="d-flex flex-wrap  align-items-center">
                                <div class="">
                                    <img src={{asset("images/produits/8.jpeg")}}
                                                        width='50px'
                                                        height='50px'
                                                        class='rounded-circle '
                                                    >
                                </div>
                                <div class="flex-grow-1 mx-2 nmx-sm-0">
                                    <div>
                                        <div class="d-flex flex-wrap-sm">
                                            <div class=" col-md-6 col-sm-12 p-0 nmy-sm-1">
                                                <x-npl::input.select3  name="client"  placeholder="Nom du client" required="false"
                                                                  id="client" class=" " style="width: 100%;"
                                                                  :redirect="url('contact/createwithretour/create_vente/client')" redirect_text="Nouveau Client"
                                                                  redirect_icon="add"
                                                                  :dt="$clients" :value="$clientidd"  />
                                             </div>
                                            <button class="btn btn-warning " style="display: none;" id="reload-btn" type="button">
                                                <i class="material-icons">refresh</i>
                                            </button>


                                            {{-- @if(\App\Util\Access::canAccess('vente_paye_non_livre',['c'])) --}}

                                            {{-- @if(Auth::user()->role->nom=='Cassier' || Auth::user()->role->nom=='Administration') --}}
                                                <x-npl::input.text name="montant" labelText="Identifiant" type="number" class="col-md-6  col-sm-12 nmy-sm-1"
                                                            placeholder="montant" id="montant_vente_form" />
                                            {{-- @endif --}}
                                            {{-- @endif --}}
                                        </div>
                                        <div class="d-flex mt-1 nmy-sm-1">
                                            {{-- <x-npl::input.text  name="nom" placeholder="nom du client" id="nom" class="" :value="$vente->nom"/>
                                            <x-npl::input.text  name="telephone" placeholder="telephone" id="telephone" class="" :value="$vente->telephone"/> --}}
                                        </div>
                                    </div>
                                </div>


                                <div class="flex-grow-1 mx-2 mx-sm-0">
                                    <textarea class="form-control w-100" id="exampleFormControlTextarea1" placeholder="Note ..." name="note" rows="3">{{$vente->note}}</textarea>
                                </div>
                            </div>

                        </x-npl::forms.form-table-item>

                    </x-npl::forms.form-table >
           @if(\App\Util\Access::canAccess('vente_bois',['c']))
            <div class="row ">
                <div class="col-md-12 col-sm-12">


                    <x-npl::forms.form-table >
                        {{-- <x-npl::forms.form-table-radios name="livraison" labelText="Livraison" required="true"  id="livraison"
                        :dt="['complet'=>'Complet','incomplet'=>'Incomplet']" value="complet" /> --}}
                        <x-npl::forms.form-table-item  class="mt-0 pt-0">
                                <x-npl::noppal-editor-table.table
                                            classTable=""
                                            classTh="border-top-0 border-bottom-0"
                                            idTable='d'
                                             id='ligne_vente'
                                            :dd="$valuesLignesVente()"
                                            :columns="$getColumns()"/>
                        </x-npl::forms.form-table-item >
                    </x-npl::forms.form-table >



                </div>

            </div>
            @endif
    </div>

    {{-- <button name="" id="" class="btn btn-success " type="submit">Envoyer</button> --}}


</form>




@once
    @push('script2')
    <script>

        $(function(){


            $('#client').select2({
                width: 'style' // need to override the changed default
            });
            $('.npl-editor-produits').select2();
                $.prixContact=@json($contactPrix());


                function bloque(){
                    $('#m_total').html("------");
                    $('#reload-btn').show();
                    $('#d input,#d select').css('color','black');
                    $('#d input,#d select').css('background-color','black');
                    $('#d__btn___add').unbind();
                    $('#reload-btn').focus();

                }

                function debloque(){
                    $('#d input,#d select').css('color','#495057');
                    $('#d select').css('background-color','white');
                    $('#d input').css('background-color','#e9ecef');
                    $('reload-btn').hide();
                    $('#d__btn___add').bind();


                    total();
                }

                function getPrix(type_produit,$bois_id,prix_standard){
                    if($.prixContact){
                        for (const contact_prix of $.prixContact) {
                            if(contact_prix.bois_id==$bois_id){
                                return contact_prix.prix_vente;
                            }
                        }
                    }

                    return prix_standard;
                }

                function mtotal(){
                    let sommeTotal=0;
                    $(".editor_montantT").each(function (index, element) {
                        sommeTotal+=Number.parseInt($(element).val());
                    });
                    $('#m_total').html(new Intl.NumberFormat().format(sommeTotal)+" FCFA");

                    sommeTotal=0;
                    $(".ligne-total-tronc").each(function (index, element) {
                        sommeTotal+=Number.parseInt($(element).val());
                    });
                    console.log("ttttttttttttttttttttttttttttttttttt");
                    console.log(sommeTotal);
                    $('#m_total_kg').html(new Intl.NumberFormat().format(sommeTotal)+" Kg");
                }

                function monnaie(){
                    let m_recu=Number.parseInt($("#mrecu").val());
                    console.log(m_recu);
                    let m_total=Number.parseInt($("#m_total").html());
                    console.log(m_recu - m_total);
                    if(m_recu>m_total){
                        let monnaie=m_recu - m_total;
                        $('#monnaie').html(new Intl.NumberFormat().format(monnaie)+" FCFA");
                    }
                    else{
                        $('#monnaie').html("no monnaie");
                    }
                }

                function total(){
                    mtotal();
                    monnaie();
                }

                function updateRow(index){
                    console.log("yyyyyyyyyyyyyyyy;")
                    let cellValue = editor.getColumn('produits').getCellValue(index);

                    if(cellValue){
                        let dataValueProduit = editor.getColumn('produits').getDataCell(index);

                        let valueCategorie=editor.getColumn('categories').getCellValue(index);

                        if(valueCategorie==1){
                            let prix=getPrix('tronc',dataValueProduit['bois'].id,dataValueProduit['bois'].prix_tronc);
                            editor.getColumn('quantite').setCellValue(index,dataValueProduit['poids']);
                            editor.getColumn('prix').setCellValue(index,prix);
                            editor.getColumn('montantT').setCellValue(index,prix*dataValueProduit['poids']);
                            console.log('prix');
                            console.log(prix);
                            editor.getInput(index,'prix').disabled="disabled";
                            let editorquantie=editor.getInput(index,'quantite');
                            $(editorquantie).prop('readonly', true);;
                            $(editorquantie).addClass('ligne-total-tronc');;
                            editor.getInput(index,'montantT').disabled="disabled";
                            console.log(dataValueProduit);
                        }
                        else{
                            let quantite=editor.getColumn('quantite').getCellValue(index);
                            if(quantite<=0){
                                editor.getColumn('quantite').setCellValue(index,1)
                                quantite=1;
                            }
                                ;
                            quantiteInput=editor.getInput(index,'quantite');
                            quantiteInput.min=dataValueProduit['0'];
                            quantiteInput.max=dataValueProduit['quantite'];

                            editor.getColumn('prix').setCellValue(index,dataValueProduit['bois'].prix_planche);

                            editor.getColumn('montantT').setCellValue(index,dataValueProduit['bois'].prix_planche*quantite);

                            editor.getInput(index,'prix').disabled="disabled";
                            let editorquantie=editor.getInput(index,'quantite');
                            $(editorquantie).prop("readonly",false);
                            $(editorquantie).prop("disabled",false);
                            editor.getInput(index,'montantT').disabled="disabled";
                            console.log(dataValueProduit);
                        }
                    }
                    else{
                        editor.getColumn('prix').setCellValue(index,0);
                        editor.getColumn('montantT').setCellValue(index,0);
                        editor.getColumn('quantite').setCellValue(index,0);
                    }
                }

                let editor =  $('#d').nplEditorTable();
                console.log(editor);
                editor.getColumn('produits').addEventInput('change',function(e){
                    //alert('bonjour');
                    updateRow(e.rowIndex);
                    console.log('gggggggggggggggggggggggggggg');
                    console.log(e.rowIndex);
                    editor.updateRow(e.rowIndex);

                });

                editor.getColumn('produits').addEventInput('load',function(e){
                    $(e.target).select2();

                });


                editor.getColumn('quantite').addEventInput('change',function(e){
                    total();
                });

                editor.getColumn('categories').on('update-item',function(e){
                    let i=e.rowIndex;
                    if(e.value==1){
                       $($('.npl-editor-quantite')[i]).prop('readonly','readonly');
                        $('.npl-editor-prix').prop('disabled','disabled');
                        $('.npl-editor-montant').prop('disabled','disabled');
                    }
                    else {
                        $($('.npl-editor-quantite')[i]).prop('readonly',false);
                        $('.npl-editor-prix').prop('disabled','disabled');
                        $('.npl-editor-montant').prop('disabled','disabled');
                    }
                });
                editor.getColumn('categories').addEventInput('change',function(e){
                    console.log(e);
                    e.editorTable.getColumn('produits').setCellValue(e.rowIndex,0);
                    updateRow(e.rowIndex);
                    e.editorTable.updateRow(e.rowIndex);

                });

                editor.on('delete-row',function(value){
                    total();
                });

                editor.on('update',function(value){
                    total();
                });



                $("#mrecu,.editor_montantT").on('change',function(){
                    total();
                })
                $('#client').on('change',function(e){
                    let val =$(this).val();
                    console.log(val);
                    if(val!='0'){
                        $("#nom").val("");
                        $("#nom").prop('disabled','disabled');
                        $("#telephone").val("");
                        $("#telephone").prop('disabled','disabled');
                        recuperePrixClient(val);
                    }
                    else{
                        console.log("entrer");
                        $("#nom").prop('disabled',false);
                        $("#telephone").prop('disabled',false);
                        $.prixContact=[];
                        updateRowQuantite();
                        editor.update();
                    }
                });

                $('#quant').on('change',function(e){
                   console.log( $('#compte').text(""));
                    console.log('fait');


                });


            function recuperePrixClient(client_id){
                console.log('lance');
                $.ajax({
                    url: "{{url('contact_prix/')}}/"+client_id,
                    type: "get",
                    dataType: "json",
                    success: function (response) {
                        if(response.status){
                            debloque();
                            $.prixContact=response.data;
                            updateRowQuantite();
                            editor.update();
                        }
                        else{
                            bloque();
                        }
                    },
                    error:function(){
                        bloque();
                        alert('Verifier la connexion impossible de joindre le serveur');
                    }

                });
            }

            $("#reload-btn").click(function(){
                recuperePrixClient($('#client').val());
            });

            function updateRowQuantite(){
                let editor =  $('#d').nplEditorTable();
                for (let index = 0; index < editor.data.length; index++) {
                    console.log("wawawa")

                    let cellValue = editor.getColumn('produits').getCellValue(index);
                    console.log(cellValue);
                    if(cellValue){
                        updateRow(index);
                    }
                }

            }
            @if($vente->id)
            updateRowQuantite();
            @endif



        });
    </script>
@endpush
@endonce

@push('script2')
<script>
    $(function(){
        setTimeout(function(){
            let editor = $('#d').nplEditorTable();
            editor.update();

            console.log(editor.data);
        },100);

    });
</script>

@endpush
