@if(isset($planche->id))
   @props([
        'url_form'=>url("planche/".$planche->id),
        'method_form'=>'post'
   ])
@else
    @props([
        'url_form'=>url("planche/"),
        'method_form'=>'post'
    ])
@endif



@section('ly-main-top')
<x-npl::navs-tabs.nav id="myTab" class="px-2  ">
    <x-npl::navs-tabs.item text="Information Générale" idPane="general"  id="general-tab"  active="true" classLink="ml-3" />
    <x-npl::navs-tabs.item text="Details" idPane="details" id="details-tab"  />
</x-npl::navs-tabs.nav>
@endsection

<form action="{{ $url_form}}" method="post" id="create_planche_form" enctype="multipart/form-data">
    @if(isset($planche->id))
        @method('PUT')
    @endif
    @csrf
    <input type="hidden" value="{{  (isset($planche->id)) ? $planche->id :''}}">
    <x-npl::navs-tabs.content id="myTabContent" class="px-4 py-3" >
        {{-- div general --}}
        <x-npl::navs-tabs.pane id="general" active="true" >
            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-12">

                     <x-npl::forms.form-table>

                        <x-npl::forms.form-table-text name="m3" labelText="Volume(m3)"  :value="$planche->m3"
                                  placeholder="volume"  required="true" id="m3" typpe="number" step="0.1" />

                        <x-npl::forms.form-table-select name="bois" labelText="Bois" :value="$planche->bois_id"
                                    required="true" id="prix_planche" :dt="$bois"  />

                        <x-npl::forms.form-table-text name="quantite" labelText="Quantité(m3)"  :value="$planche->quantite"
                                        placeholder="quantite"  required="true" id="quantite" typpe="number"   />


                        <x-npl::forms.form-table-text name="longueur" labelText="Longueur(m)" :value="$planche->longueur"
                                        placeholder="Longueur" id="longueur" typpe="number" step="0.1"/>

                        <x-npl::forms.form-table-text name="largueur" labelText="Larguer (m)" :value="$planche->largueur"
                                    placeholder="largueur" required="true" id="largueur" typpe="number" step="0.1" />

                        <x-npl::forms.form-table-select name="epaisseur" labelText="Epaisseur(m)"
                                                         :dt="$epaisseurs"
                                                        placeholder="Diametre" id="epaisseur"/>

                    </x-npl::forms.form-table>

                </div>






            </div>
        </x-npl::navs-tabs.pane>
        {{-- droit --}}
        <x-npl::navs-tabs.pane id="details"  >
            @if($planche->id)
                <x-util.detail :model="$planche" />
            @endif

        </x-npl::navs-tabs.pane>


    </x-npl::navs-tabs.content>

</form>
