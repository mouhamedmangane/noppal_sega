@extends('npl::layouts.ly-list')

@section("ly-toolbar")
    <x-npl::tool-bar.bar>
        <x-npl::tool-bar.link id="nouveau_tronc_tb" icon="add" text="Nouveau" url="{{ url('tronc/create') }}"  :canAccess="['tronc',['c']]" evidence="btn-primary"  class="ml-2" />

        <x-npl::tool-bar.button id="modifier_tronc_tb" icon="edit" text="Modifier" :canAccess="['tronc',['u']] "/>
        <x-npl::tool-bar.button id="supprimer_tronc_tb" icon="delete" text="Supprimer" :canAccess="['tronc',['d']]" />
<!--         <x-npl::tool-bar.button id="archiver_tronc_tb" icon="archive" text="Archiver"/>
        <x-npl::tool-bar.button id="desarchiver_tronc_tb" icon="unarchive" text="Déarchiver"/> -->
        <x-npl::data-table.group-by-btn id="groupby_bois_tb"  label="Grouper Par" idDataTable="myDataTable"
                                           :dt="['bois'=>'Par Bois']" defaultSelected=''  />
        <x-npl::filters.filter :filter="$getFilter()"/>


    </x-npl::tool-bar.bar>
@endsection

@section("ly-title")
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="gavel" taille="16"/>
        </x-slot>
        <x-npl::links.select-link-dt idDataTable="myDataTable" value="tous"
                                    :dt="[
                                        url('tronc/data')=>'Liste des troncs',
                                        url('tronc/data/archiver')=>'Liste des troncs Archivées',
                                    ]"
                                    class="mx-2" />
        <x-slot name="right">
            <x-npl::filters.search-filter id='mySearch' name="tous" dataTableId="myDataTable" />
        </x-slot>
    </x-npl::title-bar.bar>
@endsection


@section('ly-main-content')
    <x-tronc.util.liste />
@endsection

@section('ly-main-bot')
        <div class="d-flex justify-content-between align-items-center flex-wrap-sm  border">
            <div id='bas-left' class="ml-2 text-center">

            </div>

            <span style="" class=" bas-entre">
                <span clas="" id="total-kl-tronc"> </span>
                <span clas="ml-1" id="total-tronc"> </span>
            </span>

            <div id="bass-right" class="mr-2 d-flex">

            </div>

        </div>
@endsection

@push("script0")
<script>
    $(function(){
        if(!$.AfterLoadDataTable){
            $.AfterLoadDataTable={};
        }

        $.AfterLoadDataTable.afterLoadTronc=function (json){
            $('#total-kl-tronc').html( " Total kg  : "+json.total_kl_tronc+' kg');
            $('#total-tronc').html( " Total Tronc : "+json.total_tronc+' unité(s)');
        }
    })

     </script>
@endpush
