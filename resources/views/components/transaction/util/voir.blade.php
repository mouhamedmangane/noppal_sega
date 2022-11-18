@section("ly-main-top")
<x-npl::navs-tabs.nav id="myTab" class="px-2  ">
    <x-npl::navs-tabs.item text="Information General" idPane="general"  id="general-tab"  active="true" classLink="ml-3" />
    <x-npl::navs-tabs.item text="Details" idPane="details" id="detail-tab"  />
</x-npl::navs-tabs.nav>
@endsection
    <x-npl::navs-tabs.content id="myTabContent" class="px-4 py-3" >
      <x-npl::navs-tabs.pane id="general" active="true" >
        <div class="row">


            <div class="col-md-6 col-sm-12 my-sm-1">
                <div class="border shadow">
                    {{-- <div >
                        <h5 class="pt-3 pb-2 px-3 ">Bilan</h5>
                    </div> --}}
                    <div class="">
                        <x-npl::table.key-value-list class="w-100 liste-simple ">
                            @if($transaction->type_depense_id)
                                <x-npl::table.key-value-list-item key="Type Dépense :" :value="$transaction->type_depense_id" />
                            @endif
                           
                            <x-npl::table.key-value-list-item key="Somme :" :value="number_format($transaction->somme,0,'.',' ')"  i-Badge="FCFA" />
                            <x-npl::table.key-value-list-item key="Desccription" :value="$transaction->description" />
                            <x-npl::table.key-value-list-item key="Note :" :value="$transaction->note"  />
                        </x-npl::table.key-value-list>
                    </div>

                </div>

            </div>


        </div>
      </x-npl::navs-tabs.pane>



      <x-npl::navs-tabs.pane id="details"  >
            <x-util.detail :model="$transaction" />
      </x-npl::navs-tabs.pane>

    </x-npl::navs-tabs.content>








