@if(isset($bois->id))
   @props([
        'url_form'=>url("bois/".$bois->id),
        'method_form'=>'post'
   ])
@else
    @props([
        'url_form'=>url("bois/"),
        'method_form'=>'post'
    ])
@endif



@section('ly-main-top')
<x-npl::navs-tabs.nav id="myTab" class="px-2  ">
    <x-npl::navs-tabs.item text="Information Générale" idPane="general"  id="general-tab"  active="true" classLink="ml-3" />
    <x-npl::navs-tabs.item text="Details" idPane="details" id="details-tab"  />
</x-npl::navs-tabs.nav>
@endsection

<form action="{{ $url_form}}" method="post" id="create_bois_form" enctype="multipart/form-data">
    @if(isset($bois->id))
        @method('PUT')
    @endif
    @csrf
    <input type="hidden" value="{{  (isset($bois->id)) ? $bois->id :''}}">
    <x-npl::navs-tabs.content id="myTabContent" class="px-4 py-3" >
        {{-- div general --}}
        <x-npl::navs-tabs.pane id="general" active="true" >
            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-12">

                     <x-npl::forms.form-table>

                        <x-npl::forms.form-table-text name="name" labelText="Nom"  :value="$bois->name"
                                  placeholder="Donnner le nom" id="nom" />
                        <x-npl::forms.form-table-text name="prix_tronc" labelText="Prix Tronc (Kg)" :value="$bois->prix_tronc"
                                    placeholder="Prix Tronc" id="prix_tronc" typpe="number" />

                        <x-npl::forms.form-table-text name="prix_planche" labelText="Prix Planche (m3)" :value="$bois->prix_planche"
                                  placeholder="Prix Planche" id="prix_planche" typpe="number" />
                    </x-npl::forms.form-table>

                </div>






            </div>
        </x-npl::navs-tabs.pane>
        {{-- droit --}}
        <x-npl::navs-tabs.pane id="details"  >
            @if($bois->id)
                <x-util.detail :model="$bois" />
            @endif

        </x-npl::navs-tabs.pane>


    </x-npl::navs-tabs.content>

</form>
