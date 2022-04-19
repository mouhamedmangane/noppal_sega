
@section('content')

<div class="ly-content ly-content-title">
    <div class="ly-alert">
        @yield('ly-alert')
   </div>
    <div class="ly-title " style="">
         @yield('ly-title')
    </div>
    <div class="ly-main" id="my-main">
        <div class="ly-main-top">
                @yield('ly-main-top')
            </div>
        <div class="ly-main-content bg-white"  >
            @yield('ly-main-content')
        </div>

    </div>
</div>
@endsection
