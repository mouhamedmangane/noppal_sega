@extends('layouts.print')
@section('head')
 <title>Vente VS-{{$vente->id}}</title>
    <style type="text/css">
    @page { size: A4 landscape; }
  </style>
@endsection

@section('body')
    <div class="d-flex justify-content-lg-between">
        <div class="col-md6">
            @include('pages.vente.printFactureSimple')
        </div>

        <div  class="mx-5" style="width:1px;height: 1000px;border-left:1px dashed black; "></div>

        <div class="col-md6">
            @include('pages.vente.printFactureDoublons')
        </div>

    </div>

@endsection
