@if(isset($tronc->id))
   @props([
        'url_form'=>url("tronc/".$tronc->id),
        'method_form'=>'post'
   ])
@else
    @props([
        'url_form'=>url("tronc/"),
        'method_form'=>'post'
    ])
@endif



@section('ly-main-top')
<x-npl::navs-tabs.nav id="myTab" class="px-2  ">
    <x-npl::navs-tabs.item text="Information Générale" idPane="general"  id="general-tab"  active="true" classLink="ml-3" />
    <x-npl::navs-tabs.item text="Details" idPane="details" id="details-tab"  />
</x-npl::navs-tabs.nav>
@endsection

<form action="{{ $url_form}}" method="post" id="create_tronc_form" enctype="multipart/form-data">
    @if(isset($tronc->id))
        @method('PUT')
    @endif
    @csrf
    <input type="hidden" value="{{  (isset($tronc->id)) ? $tronc->id :''}}">
    <x-npl::navs-tabs.content id="myTabContent" class="px-4 py-3" >
        {{-- div general --}}
        <x-npl::navs-tabs.pane id="general" active="true" >
            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-12">

                     <x-npl::forms.form-table>

                        <x-npl::forms.form-table-text name="identifiant" labelText="Identifiant"  :value="$tronc->identifiant"
                                  placeholder="Identifiant" id="Identifiant" />

                        <x-npl::forms.form-table-text name="poids" labelText="Poids (Kg)" :value="$tronc->poids"
                                    placeholder="Poids" required="true" id="prix_tronc" typpe="number" step="0.2" />
                        <x-npl::forms.form-table-select name="bois" labelText="Bois" :value="$tronc->bois_id"
                                 required="true" id="prix_tronc" :dt="$bois"  />


                        <x-npl::forms.form-table-text name="longueur" labelText="Longueur(m)" :value="$tronc->longueur"
                                  placeholder="Longueur" id="longueur" typpe="number" step="0.2"/>

                        <x-npl::forms.form-table-text name="diametre" labelText="Diametre(m)" :value="$tronc->diametre"
                                  placeholder="Diametre" id="diametre" typpe="number" step="0.2"/>

                        @if (!$tronc->id)
                            <x-npl::forms.form-table-select name="coef" labelText="Coef" value="1.03"
                                    required="true" id="coeftronc" :dt="['1.03'=>'1.03','1'=>'1']"  />
                        @endif



                    </x-npl::forms.form-table>

                </div>






            </div>
        </x-npl::navs-tabs.pane>
        {{-- droit --}}
        <x-npl::navs-tabs.pane id="details"  >
            @if($tronc->id)
                <x-util.detail :model="$tronc" />
            @endif

        </x-npl::navs-tabs.pane>


    </x-npl::navs-tabs.content>

</form>
