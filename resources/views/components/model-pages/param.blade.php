@extends('layout.main')

@section('head-body')
    <x-npl::util.header />
@endsection

@section('sidebar')
    <x-npl::navs.sidebar :model="$getSidebarData()" id="sidebar" />
@endsection

{{ $slot }}