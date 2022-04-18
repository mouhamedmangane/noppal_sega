@if(isset($depense->id))
   @props([
        'url_form'=>url("depense/".$depense->id),
        'method_form'=>'post'
   ])
@else
    @props([
        'url_form'=>url("depense/"),
        'method_form'=>'post'
    ])
@endif



@section('ly-main-top')
<x-npl::navs-tabs.nav id="myTab" class="px-2  ">
    <x-npl::navs-tabs.item text="Information Générale" idPane="general"  id="general-tab"  active="true" classLink="ml-3" />
    <x-npl::navs-tabs.item text="Details" idPane="details" id="details-tab"  />
</x-npl::navs-tabs.nav>
@endsection

<form action="{{ $url_form}}" method="post" id="create_depense_form" enctype="multipart/form-data">
    @if(isset($depense->id))
        @method('PUT')
    @endif
    @csrf
    <input type="hidden" value="{{  (isset($depense->id)) ? $depense->id :''}}" name="id">
    <x-npl::navs-tabs.content id="myTabContent" class="px-4 py-3" >
        {{-- div general --}}
        <x-npl::navs-tabs.pane id="general" active="true" >
            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-12">

                     <x-npl::forms.form-table>

                        <x-npl::forms.form-table-select name="type_depense" labelText="Type_depense" :value="$depense->type_depense_id"
                                 required="true" id="type_depense" :dt="$type_depenses"  />

                        <x-npl::forms.form-table-text name="description" labelText="description"  :value="$depense->description"
                                  placeholder="description" id="description" />

                        <x-npl::forms.form-table-text name="somme" labelText="Somme (Kg)" :value="$depense->somme"
                                    placeholder="Somme" required="true" id="prix_depense" typpe="number" step="0.2" />

                        <x-npl::forms.form-table-textarea name="note" labelText="Note" rows="3"
                            placeholder="note ..." id="note" />



                    </x-npl::forms.form-table>

                </div>






            </div>
        </x-npl::navs-tabs.pane>
        {{-- droit --}}
        <x-npl::navs-tabs.pane id="details"  >
            @if($depense->id)
                <x-util.detail :model="$depense" />
            @endif

        </x-npl::navs-tabs.pane>


    </x-npl::navs-tabs.content>

</form>
