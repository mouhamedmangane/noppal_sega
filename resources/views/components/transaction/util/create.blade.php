@if(isset($transaction->id))
   @props([
        'url_form'=>url("transaction/".$transaction->id),
        'method_form'=>'post'
   ])
@else
    @props([
        'url_form'=>url("transaction/"),
        'method_form'=>'post'
    ])
@endif



@section('ly-main-top')
<x-npl::navs-tabs.nav id="myTab" class="px-2  ">
    <x-npl::navs-tabs.item text="Information Générale" idPane="general"  id="general-tab"  active="true" classLink="ml-3" />
    <x-npl::navs-tabs.item text="Details" idPane="details" id="details-tab"  />
</x-npl::navs-tabs.nav>
@endsection

<form action="{{ $url_form}}" method="post" id="create_transaction_form" enctype="multipart/form-data">
    @if(isset($transaction->id))
        @method('PUT')
    @endif
    @csrf
    <input type="hidden" value="{{  (isset($transaction->id)) ? $transaction->id :''}}" name="id">
    <x-npl::navs-tabs.content id="myTabContent" class="px-4 py-3" >
        {{-- div general --}}
        <x-npl::navs-tabs.pane id="general" active="true" >
            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-12">

                     <x-npl::forms.form-table>

                        <x-npl::forms.form-table-select name="e_s" labelText="E/S" :value="($transaction->somme>0) ? 1:0"
                            required="true" id="e_s" :dt="['SORTIE','ENTREE']"  />
                        <x-npl::forms.form-table-select name="type_depense" labelText="Type" :value="$transaction->type_depense_id"
                                 required="" id="type_depense" :dt="$type_depenses"  />

                        <x-npl::forms.form-table-text name="description" labelText="description"  :value="$transaction->description"
                                  placeholder="description" id="description" />

                        <x-npl::forms.form-table-text name="somme" labelText="Somme (FCFA)" :value="($transaction->somme>0) ? $transaction->somme:-$transaction->somme"
                                    placeholder="Somme" required="true" id="prix_transaction" typpe="number" step="0.2" />

                        <x-npl::forms.form-table-textarea name="note" labelText="Note" rows="3"
                            placeholder="note ..." id="note" />



                    </x-npl::forms.form-table>

                </div>






            </div>
        </x-npl::navs-tabs.pane>
        {{-- droit --}}
        <x-npl::navs-tabs.pane id="details"  >
            @if($transaction->id)
                <x-util.detail :model="$transaction" />
            @endif

        </x-npl::navs-tabs.pane>


    </x-npl::navs-tabs.content>

</form>
@push('script')
    <script>
        $(function(){
            console.log('yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy');
        $( "#e_s" ).on('change',function() {
               // 
                if($("#e_s").val()=="1"){
                  //  alert($("#e_s").val());
                    $("#type_depense").prop("disabled",true);
                }
                else
                     $("#type_depense").prop("disabled",false);
            });
        })
    </script>
@endpush