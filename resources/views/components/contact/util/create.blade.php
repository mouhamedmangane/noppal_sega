@if(isset($contact->id))
   @props([
        'url_form'=>url(url("contact/".$contact->id)),
        'method_form'=>'post'
   ])
@else
    @props([
        'url_form'=>url("contact/"),
        'method_form'=>'post'
    ])
@endif



@section('ly-main-top')
<x-npl::navs-tabs.nav id="myTab" class="px-2  ">
    <x-npl::navs-tabs.item text="Information Générale" idPane="general"  id="general-tab"  active="true" classLink="ml-3" />
    @if(\App\Util\Access::canAccess('role',['c']))
        <x-npl::navs-tabs.item text="Prix" idPane="prix" id="prix-tab"  />
    @endif
    <x-npl::navs-tabs.item text="Carte d'dentité" idPane="carte" id="carte-tab"  />
    <x-npl::navs-tabs.item text="Details" idPane="details" id="details-tab"  />

</x-npl::navs-tabs.nav>
@endsection

<form action="{{ $url_form}}" method="post" id="create_contact_form" enctype="multipart/form-data">
    @if(isset($contact->id))
        @method('PUT')
    @endif
    @csrf
    <input type="hidden" value="{{ $contact->id }}">
    @if($vente)
        <input type="hidden" name="vente_id" value="{{ $vente->id }}">
    @endif

    <x-npl::navs-tabs.content id="myTabContent" class="px-4 py-3" >
        {{-- div general --}}
        <x-npl::navs-tabs.pane id="general" active="true" >
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">

                    <div class="shadow border mb-3 p-2">
                        <x-npl::input.photo id="photo" name="photo"
                                               :url="(isset($contact->photo) && !empty($contact->photo))?asset('images/contacts/'.$contact->photo):''" x="150" y="150"
                                               classImage=" rounded-circle"/>
                    </div>



                     <x-npl::forms.form-table>
                        <x-npl::forms.form-table-multi-check name="client_fournisseur" labelText="Le Contact" required="true" type="switch"
                        :dt="['client'=>'Client','fournisseur'=>'Founisseur']" :value="$client_fournisseur" />
                        @if(!$contact->id)
                            <x-npl::forms.form-table-text name="compte" labelText="Etat Compte Initial" :value="$contact->compte"
                                typpe="number"  placeholder="Ex : 1000 ou -1000" id="email"  />
                        @endif
                    </x-npl::forms.form-table>
                </div>



                <div class="col-lg-7 col-md-8 col-sm-12">
                    <x-npl::forms.form-table >

                        <x-npl::forms.form-table-text name="nom" labelText="nom" :value="$contact->nom"
                                required="true"  placeholder="Donner le nom" id="nom"  />

                        <x-npl::forms.form-table-text name="email" labelText="Email" :value="$contact->email"
                                required="true" placeholder="Donner le login" id="Email"/>

                        <x-npl::forms.form-table-text name="ncni" labelText="N° CNI" :value="$contact->ncni"
                                   placeholder="N° carte d identité" id="ncni" />

                        <x-npl::forms.form-table-telephone name="tel1" labelText="Telephone 1"  :indicatif="$telephones[0]['indicatif']"
                                 :numero="$telephones[0]['numero']" :idTelephone="$telephones[0]['id']"
                                 required="true"  placeholder="Donner le Telephone" id="telephone0" />
                        <x-npl::forms.form-table-telephone name="tel2" labelText="Telephone 2"  :indicatif="$telephones[1]['indicatif']"
                                :numero="$telephones[1]['numero']" :idTelephone="$telephones[1]['id']"
                                 placeholder="Donner le Telep  hone" id="telephone1" />

                        <x-npl::forms.form-table-text name="fonction" labelText="Fonction" :value="$contact->fonction"
                                    placeholder="Ex: électricien,livreur ..." id="fonction" />

                    </x-npl::forms.form-table>
                </div>




            </div>
        </x-npl::navs-tabs.pane>
        {{-- droit --}}
        <x-npl::navs-tabs.pane id="carte"  >
            <div class="shadow border mb-3 p-2">
                <x-npl::input.photo id="photo_carte1" name="ncni_photo_1"
                                       :url="(isset($contact->ncni_photo_1) && !empty($contact->ncni_photo_1))?asset('images/contacts/'.$contact->ncni_photo_1):''" x="450" y="220"
                                       classImage=" rounded-circle"/>
                <x-npl::input.photo id="photo_carte2" name="ncni_photo_2"
                    :url="(isset($contact->ncni_photo_2) && !empty($contact->ncni_photo_2))?asset('images/contacts/'.$contact->ncni_photo_2):''" x="450" y="220"
                    classImage=" rounded-circle"/>
            </div>
        </x-npl::navs-tabs.pane>

        @if(\App\Util\Access::canAccess('role',['c']))
        <x-npl::navs-tabs.pane id="prix"  >
            <div class="row ">
                <div class="col-md-12 col-sm-12">


                    <x-npl::forms.form-table >
                        <x-npl::forms.form-table-item  class="mt-0 pt-0">
                                <x-npl::noppal-editor-table.table
                                            classTable=""
                                            classTh="border-top-0 border-bottom-0"
                                            idTable='d'
                                             id='prix_contact'
                                            :dd="$valuesLignesVente()"
                                            :columns="$getColumns()"/>
                        </x-npl::forms.form-table-item >
                    </x-npl::forms.form-table >



                </div>

            </div>
        </x-npl::navs-tabs.pane>
        @endif


        {{-- droit --}}
        <x-npl::navs-tabs.pane id="details"  >
            @if($contact->id)
                <x-util.detail :model="$contact" />
            @endif

        </x-npl::navs-tabs.pane>


    </x-npl::navs-tabs.content>

</form>
<div>
    <!-- An unexamined life is not worth living. - Socrates -->
</div>
