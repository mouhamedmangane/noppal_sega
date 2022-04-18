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
    <x-npl::navs-tabs.item text="Carte d'dentité" idPane="carte" id="carte-tab"  />
    <x-npl::navs-tabs.item text="Prix" idPane="prix" id="prix-tab"  />

    @if ($contact->is_client==1)
        <x-npl::navs-tabs.item text="Client" idPane="client" id="client-tab"  />
    @endif
    @if ($contact->is_fournisseur==1)
        <x-npl::navs-tabs.item text="Fournisseur" idPane="fournisseur" id="fournisseur-tab"  />
    @endif
    <x-npl::navs-tabs.item text="Details" idPane="details" id="details-tab"  />
</x-npl::navs-tabs.nav>
@endsection

    <x-npl::navs-tabs.content id="myTabContent" class="px-4 py-3 " >
        {{-- div general --}}
        <x-npl::navs-tabs.pane id="general" active="true" >
            <div class="row">
                <div  class="col-md-8 col-sm-12">
                    <div class="border shadow p-2">
                            <h4 class="text-primary" >{{$contact->nom}}</h4>
                            <div class="row ">
                                <div class="col-md-4 col-sm-12">

                                     <x-npl::input.photo id="photo" name="photo" activeText="false" :url="(isset($contact->photo) && !empty($contact->photo))?asset('images/contacts/'.$contact->photo):''" x="300" y="220" />

                                </div>

                                <div class="col-md-8 col-sm-12">
                                    <x-npl::table.key-value-list class="w-100 liste-simple ">
                                        <x-npl::table.key-value-list-item key="Fonctions :" value="">
                                            <x-slot name="valuee">
                                                @if ($contact->is_client==1)
                                                    <x-npl::bagde.badge text="Client" class="badge-success"  />
                                                @endif
                                                @if ($contact->is_fournisseur==1)
                                                    <x-npl::bagde.badge text="Fournisseur" class="badge-warning"  />
                                                @endif
                                                @if (!empty($contact->fonction))
                                                    <x-npl::bagde.badge :text="$contact->fonction" class="badge-danger"  />
                                                @endif

                                            </x-slot>
                                        </x-npl::table.key-value-list-item>
                                        <x-npl::table.key-value-list-item key="Tel 1 :" :value="$tels[0]" />
                                        <x-npl::table.key-value-list-item key="Tel 2 :" :value="$tels[1]" />
                                        <x-npl::table.key-value-list-item key="email :" :value="$contact->email" />
                                        <x-npl::table.key-value-list-item key="NCNI:" :value="$contact->ncni" />
                                        <x-npl::table.key-value-list-item key="Modifer le :" :value="$contact->updated_at->format('d/m/Y \à H\h i \m\n')" />
                                        <x-npl::table.key-value-list-item key="Crée le :" :value="$contact->created_at->format('d/m/Y \à H\h i \m\n')" />
                                    </x-npl::table.key-value-list>
                                </div>
                            </div>

                        </div >
                </div>

            </div>
        </x-npl::navs-tabs.pane>


        <x-npl::navs-tabs.pane id="carte"  >
            <div class="shadow border mb-3 p-2">
                <x-npl::input.photo id="photo_carte1" name="ncni_photo_1" open="true"
                                       :url="(isset($contact->ncni_photo_1) && !empty($contact->ncni_photo_1))?asset('images/contacts/'.$contact->ncni_photo_1):''" x="450" y="220"
                                       classImage=" rounded-circle"/>
                <x-npl::input.photo id="photo_carte2" name="ncni_photo_2" open="true"
                    :url="(isset($contact->ncni_photo_2) && !empty($contact->ncni_photo_2))?asset('images/contacts/'.$contact->ncni_photo_2):''" x="450" y="220"
                    classImage=" rounded-circle"/>
            </div>
        </x-npl::navs-tabs.pane>

         <x-npl::navs-tabs.pane id="prix"  >
            <div class=" flex-grow-1">
                <div class="d-flex justify-content-center">
                    <x-npl::forms.form-table >
                        <x-npl::forms.form-table-item>
                            <x-npl::data-table.simple class="" name="myDataTable" :data="$contact_prix()" :columns="$titre()" dom="t"
                                idDivPaginate="bass-right" idDivInfo="bas-left" searchId='mySearch'/>
                        </x-npl::forms.form-table-item>
                    </x-npl::forms.form-table>
                </div>
            </div>
        </x-npl::navs-tabs.pane>

        {{-- droit --}}
        @if ($contact->is_client==1)
            <x-npl::navs-tabs.pane id="client"  >

            </x-npl::navs-tabs.pane>
        @endif

        @if ($contact->is_fournisseur==1)
            <x-npl::navs-tabs.pane id="fournisseur"  >

            </x-npl::navs-tabs.pane>
        @endif

        <x-npl::navs-tabs.pane id="details"  >
            @if($contact->id)
                <x-util.detail :model="$contact" />
            @endif
        </x-npl::navs-tabs.pane>

    </x-npl::navs-tabs.content>

<div>

</div>
