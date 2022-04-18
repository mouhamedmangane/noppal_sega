
@extends('npl::layouts.ly-title')


@section('main')

@section("ly-title")
    <x-npl::title-bar.bar>
        <x-slot name="image">
            <x-npl::icon.simple name="grid_view" taille="40" />
        </x-slot>
        <x-npl::breadcumb.bar style="font-size: 18px;" class="py-0">
            <x-npl::breadcumb.item  class="lien-sp">
                <a href="{{ url('/home') }}">DASHBORD</a>
            </x-npl::breadcumb.item>
            <x-npl::breadcumb.item active="true">
                    {{str_replace(' 00:00','',$date)}}
            </x-npl::breadcumb.item>
        </x-npl::breadcumb>
        <x-slot name="right">

            <div class="mr-4 mt-2">
                <x-npl::infos.info-list  id='mySearch'  >
                    <button data-prec="{{$date_prec}}" class="btn btn-sm btn-primary bouton rounded-0"  id="b-left"><</button>
                    <input  type="date" name="date"  class="form-control rounded-0"
                            id="date_globale" value="{{ str_replace(' 00:00','',$date)}}">
                <button data-suivant="{{$date_suivant}}" class="btn btn-sm btn-primary bouton rounded-0"  id="b-right">></button>
                </x-npl::infos.info-list>
            </div>
        </x-slot>
    </x-npl::title-bar.bar>

@endsection

@section('ly-main-content')
    <x-home.util.dashbord :date="$date" :donnees="$donnees"   />
@endsection








@push('script')
<script>
    $(function(){
        let url="{{url('home/')}}";
        $('.bouton').on('click',function(e){
            if(e.target.id=="b-left"){
                window.location.href=url+'/'+$(this).data('prec');
            }
            else if(e.target.id="b-right"){
                window.location.href=url+'/'+$(this).data('suivant');
            }
        });

        $("#date_globale").on("change",function(e){
            window.location.href=url+'/'+$(this).val();
        })



    });

</script>
@endpush
